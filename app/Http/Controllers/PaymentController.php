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
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $vnp_TransactionStatus = $request->input('vnp_TransactionStatus');
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');

        $order = DonHang::find($vnp_TxnRef);
        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'Đơn hàng không tìm thấy.');
        }

        $payment = $order->thanhToan;
        if (!$payment) {
            return redirect()->route('checkout.index')->with('error', 'Thanh toán không tồn tại.');
        }

        if ($vnp_ResponseCode === '00' && $vnp_TransactionStatus === '00') {
            $payment->trangthai = 'da_thanh_toan';
            $payment->ngaythanhtoan = now();
            $payment->save();

            $order->trang_thai = 'dang_xu_ly';
            $order->save();

            return redirect()->route('khachhang.order.show', $order->id)
                ->with('success', 'Thanh toán VNPay thành công.');
        }

        $payment->trangthai = 'that_bai';
        $payment->save();

        return redirect()->route('checkout.index')->with('error', 'Thanh toán VNPay thất bại. Mã lỗi: ' . $vnp_ResponseCode);
    }
}
