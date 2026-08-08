<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonHang;
use App\Models\DonHang;
use App\Models\ProductVariant;
use App\Models\ThanhToan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = collect(session('cart', []));
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Kiểm tra tổng số lượng trong giỏ hàng không vượt quá 10
        $totalQuantity = $cartItems->sum('quantity');
        if ($totalQuantity > 10) {
            return redirect()->route('cart.index')->with('error', 'Tổng số lượng sản phẩm trong giỏ hàng không được vượt quá 10. Vui lòng giảm số lượng trước khi thanh toán.');
        }

        $cartTotal = $cartItems->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Lấy thông tin voucher đã áp dụng từ session
        $appliedVoucher = session('applied_voucher');
        $discount = $appliedVoucher['discount'] ?? 0;
        $finalTotal = $cartTotal - $discount;

        return view('checkout.index', compact('cartItems', 'cartTotal', 'appliedVoucher', 'discount', 'finalTotal'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sdt' => 'required|string|max:20',
            'diachi' => 'required|string|max:500',
            'phuong' => 'nullable|string|max:255',
            'quan' => 'nullable|string|max:255',
            'thanhpho' => 'nullable|string|max:255',
            'phuongthuc' => 'required|string|in:cod,bank,card,stripe,vnpay,paypal,vietqr',
        ]);

        $cartItems = collect(session('cart', []));
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $cartTotal = $cartItems->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Lấy thông tin voucher đã áp dụng từ session
        $appliedVoucher = session('applied_voucher');
        $discount = $appliedVoucher['discount'] ?? 0;
        $finalTotal = $cartTotal - $discount;

        DB::beginTransaction();
        try {
            $userId = Auth::guard('khachhang')->id();
            if (!$userId) {
                return redirect()->route('home')->with('error', 'Vui lòng đăng nhập khách hàng để đặt hàng.');
            }

            $donHang = DonHang::create([
                'khachhangid' => $userId,
                'ten' => $request->ten,
                'email' => $request->email,
                'sdt' => $request->sdt,
                'diachi' => $request->diachi,
                'phuong' => $request->phuong,
                'quan' => $request->quan,
                'thanhpho' => $request->thanhpho,
                'phigiaohang' => 0,
                'tonggia' => $finalTotal,
                'giamgia' => $discount,
                'phuongthuc' => $request->phuongthuc,
                'ngaydat' => Carbon::now(),
            ]);

            $donHang->mavandon = 'DH' . now()->format('Ymd') . str_pad($donHang->id, 6, '0', STR_PAD_LEFT);
            $donHang->save();

            foreach ($cartItems as $item) {
                $variant = ProductVariant::find($item['product_variant_id'] ?? null);
                if (!$variant) {
                    $variant = ProductVariant::where('sanphamid', $item['product_id'])
                        ->where('mausacid', $item['color_id'])
                        ->where('kichcoid', $item['size_id'])
                        ->first();
                }

                ChiTietDonHang::create([
                    'donhangid' => $donHang->id,
                    'chitietsanphamid' => $variant?->id ?? 0,
                    'soluong' => $item['quantity'],
                    'dongia' => $item['price'],
                ]);
            }

            ThanhToan::create([
                'donhangid' => $donHang->id,
                'phuongthuc' => $request->phuongthuc,
                'sotien' => $finalTotal,
                'trangthai' => in_array($request->phuongthuc, ['stripe', 'vnpay', 'paypal', 'vietqr']) ? 'cho_thanh_toan' : 'da_thanh_toan',
                'ngaythanhtoan' => in_array($request->phuongthuc, ['stripe', 'vnpay', 'paypal', 'vietqr']) ? null : Carbon::now(),
            ]);

            session()->forget('cart');
            session()->forget('applied_voucher');
            DB::commit();

            if (in_array($request->phuongthuc, ['stripe', 'vnpay', 'paypal', 'vietqr'])) {
                $gatewayUrl = $this->buildGatewayUrl($request->phuongthuc, $donHang);
                return redirect()->away($gatewayUrl)->with('success', 'Đơn hàng đã được tạo. Vui lòng hoàn tất thanh toán qua cổng thanh toán sandbox.');
            }

            return redirect()->route('khachhang.order.show', $donHang->id)
                ->with('success', 'Đơn hàng của bạn đã được đặt thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi khi đặt hàng: ' . $e->getMessage());
        }
    }

    private function buildGatewayUrl(string $gateway, DonHang $order): string
    {
        $amount = (int) round($order->tonggia);
        $orderId = $order->id;

        return match ($gateway) {
            'stripe' => 'https://sandbox.stripe.com/checkout/session/' . $orderId,
            'vnpay' => $this->buildVnpayUrl($order),
            'paypal' => 'https://www.sandbox.paypal.com/checkoutnow?token=' . $orderId,
            'vietqr' => 'https://api.vietqr.io/image/970422-123456789-compact2.png?amount=' . $amount . '&addInfo=' . urlencode('Order ' . $orderId),
            default => route('khachhang.order.show', $order->id),
        };
    }

    private function buildVnpayUrl(DonHang $order): string
    {
        $vnpay = config('services.vnpay');
        $url = $vnpay['url'] ?? 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $tmnCode = $vnpay['tmn_code'] ?? '';
        $secret = $vnpay['hash_secret'] ?? '';
        $returnUrl = $vnpay['return_url'] ?: route('payment.vnpay.return');

        $params = [
            'vnp_Version' => '2.1.0',
            'vnp_Command' => 'pay',
            'vnp_TmnCode' => $tmnCode,
            'vnp_Amount' => (string) ((int) round($order->tonggia) * 100),
            'vnp_CreateDate' => now()->format('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => request()->ip() ?: '127.0.0.1',
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => 'Thanh toan don hang ' . $order->mavandon,
            'vnp_OrderType' => 'other',
            'vnp_ReturnUrl' => $returnUrl,
            'vnp_TxnRef' => (string) $order->id,
        ];

        ksort($params);
        $hashData = '';
        $query = '';
        $i = 0;
        foreach ($params as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }

        $secureHash = hash_hmac('sha512', $hashData, $secret);

        return $url . '?' . $query . 'vnp_SecureHash=' . $secureHash;
    }
}
