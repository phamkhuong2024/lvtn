<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ThanhToan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function vnpayReturn(Request $request)
    {
        $vnpayData = $request->all();

        $vnp_SecureHash = $vnpayData['vnp_SecureHash'] ?? '';
        unset($vnpayData['vnp_SecureHash'], $vnpayData['vnp_SecureHashType']);

        ksort($vnpayData);
        $hashData = '';
        $i = 0;
        foreach ($vnpayData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
        }

        $secret = config('services.vnpay.hash_secret');
        $secureHash = hash_hmac('sha512', $hashData, $secret);

        if (!hash_equals($secureHash, $vnp_SecureHash)) {
            Log::warning('VNPay return invalid signature', ['data' => $request->all()]);
            return redirect()->route('checkout.index')->with('error', 'Chữ ký thanh toán không hợp lệ.');
        }

        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $vnp_TransactionStatus = $request->input('vnp_TransactionStatus');
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');

        $order = DonHang::find($vnp_TxnRef);
        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'Đơn hàng không tìm thấy.');
        }

        $payment = $order->thanhToan;
        if (!$payment) {
            $payment = ThanhToan::create([
                'donhangid' => $order->id,
                'phuongthuc' => 'vnpay',
                'sotien' => $order->tonggia,
                'trangthai' => 'cho_thanh_toan',
            ]);
        }

        if ($payment->trangthai === 'da_thanh_toan') {
            return redirect()->route('khachhang.order.show', $order->id)
                ->with('success', 'Đơn hàng đã được thanh toán trước đó.');
        }

        if ($vnp_ResponseCode === '00' && $vnp_TransactionStatus === '00') {
            $payment->trangthai = 'da_thanh_toan';
            $payment->ngaythanhtoan = now();
            $payment->save();

            $order->trang_thai = 'dang_xu_ly';
            $order->save();

            return redirect()->route('payment.success', ['orderId' => $order->id]);
        }

        $payment->trangthai = 'that_bai';
        $payment->save();

        return redirect()->route('checkout.index')->with('error', 'Thanh toán VNPay thất bại. Mã lỗi: ' . $vnp_ResponseCode);
    }

    public function success($orderId)
    {
        $order = DonHang::with('thanhToan')->findOrFail($orderId);
        return view('payment.success', compact('order'));
    }
}
