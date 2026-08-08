<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = collect(session('cart', []));
        $cartTotal = $cartItems->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Lấy danh sách voucher đang hoạt động
        $vouchers = Voucher::where('trangthai', 1)
            ->where('ngaybatdau', '<=', now())
            ->where('ngayketthuc', '>=', now())
            ->get();

        // Lấy thông tin voucher đã áp dụng (nếu có)
        $appliedVoucher = null;
        $discount = 0;
        $finalTotal = $cartTotal;

        if (session('applied_voucher_id')) {
            $appliedVoucher = Voucher::find(session('applied_voucher_id'));
            if ($appliedVoucher && $appliedVoucher->isApplicable($cartTotal)) {
                $discount = $appliedVoucher->calculateDiscount($cartTotal);
                $finalTotal = max(0, $cartTotal - $discount);
            } else {
                // Xóa voucher không hợp lệ
                session()->forget('applied_voucher_id');
                $appliedVoucher = null;
            }
        }

        return view('cart.index', compact('cartItems', 'cartTotal', 'vouchers', 'appliedVoucher', 'discount', 'finalTotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:san_pham,id',
            'color_id' => 'required|exists:mau_sac,id',
            'size_id' => 'required|exists:kich_co,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $variant = ProductVariant::with(['mauSac', 'kichCo'])
            ->where('sanphamid', $request->product_id)
            ->where('mausacid', $request->color_id)
            ->where('kichcoid', $request->size_id)
            ->first();

        if (!$variant) {
            return back()->with('error', 'Phiên bản sản phẩm không tồn tại.');
        }

        if ($variant->soluong < $request->quantity) {
            return back()->with('error', 'Số lượng yêu cầu vượt quá hàng tồn.');
        }

        $image = $product->images()->where('mausacid', $request->color_id)->first();
        $cart = session('cart', []);
        $key = sprintf('%s_%s_%s', $product->id, $request->color_id, $request->size_id);

        $availableStock = max(0, $variant->soluong - $request->quantity);
        if ($availableStock < 0) {
            return back()->with('error', 'Số lượng yêu cầu vượt quá hàng tồn.');
        }

        if (isset($cart[$key])) {
            $newQuantity = $cart[$key]['quantity'] + $request->quantity;
            if ($newQuantity > $variant->soluong) {
                return back()->with('error', 'Số lượng yêu cầu vượt quá hàng tồn.');
            }
            $cart[$key]['quantity'] = $newQuantity;
        } else {
            $cart[$key] = [
                'key' => $key,
                'product_id' => $product->id,
                'name' => $product->ten,
                'image' => $image ? $image->hinhanh : $product->hinhanh,
                'color_id' => $request->color_id,
                'color_name' => $variant->mauSac?->ten ?? '',
                'size_id' => $request->size_id,
                'size_name' => $variant->kichCo?->ten ?? '',
                'price' => $variant->gia,
                'quantity' => $request->quantity,
                'stock' => $variant->soluong,
            ];
        }

        $variant->soluong = max(0, $variant->soluong - $request->quantity);
        $variant->save();

        session(['cart' => $cart]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => 'Sản phẩm đã được thêm vào giỏ hàng.']);
        }

        if ($request->has('buy_now') && $request->buy_now == '1') {
            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
        }

        return back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);

        if (!isset($cart[$request->key])) {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        $item = $cart[$request->key];
        $variant = ProductVariant::where('sanphamid', $item['product_id'])
            ->where('mausacid', $item['color_id'])
            ->where('kichcoid', $item['size_id'])
            ->first();

        if (!$variant) {
            unset($cart[$request->key]);
            session(['cart' => $cart]);
            return redirect()->route('cart.index')->with('error', 'Phiên bản sản phẩm không còn tồn tại.');
        }

        $previousQuantity = $item['quantity'];
        if ($request->quantity > $variant->soluong + $previousQuantity) {
            $cart[$request->key]['quantity'] = max(1, $variant->soluong + $previousQuantity);
            session(['cart' => $cart]);
            return redirect()->route('cart.index')->with('error', 'Số lượng đã được điều chỉnh theo tồn kho.');
        }

        $stockDelta = $previousQuantity - $request->quantity;
        $variant->soluong = max(0, $variant->soluong + $stockDelta);
        $variant->save();

        $cart[$request->key]['quantity'] = $request->quantity;
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
        ]);

        $cart = session('cart', []);

        if (isset($cart[$request->key])) {
            $item = $cart[$request->key];
            $variant = ProductVariant::where('sanphamid', $item['product_id'])
                ->where('mausacid', $item['color_id'])
                ->where('kichcoid', $item['size_id'])
                ->first();

            if ($variant) {
                $variant->soluong = max(0, $variant->soluong + $item['quantity']);
                $variant->save();
            }

            unset($cart[$request->key]);
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }

    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string',
        ]);

        $voucher = Voucher::where('ma_voucher', $request->voucher_code)->first();

        if (!$voucher) {
            return back()->with('error', 'Mã voucher không tồn tại.');
        }

        if (!$voucher->isActive()) {
            return back()->with('error', 'Mã voucher đã hết hạn hoặc chưa được kích hoạt.');
        }

        $cartItems = collect(session('cart', []));
        $cartTotal = $cartItems->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Kiểm tra giỏ hàng trống
        if ($cartTotal == 0) {
            return back()->with('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi áp dụng voucher.');
        }

        if (!$voucher->isApplicable($cartTotal)) {
            return back()->with('error', 'Đơn hàng chưa đạt giá trị tối thiểu để áp dụng voucher này. Cần tối thiểu: ' . number_format($voucher->giatridonhang, 0, ',', '.') . 'đ');
        }

        session(['applied_voucher_id' => $voucher->id]);

        return back()->with('success', 'Áp dụng mã voucher thành công!');
    }

    public function removeVoucher()
    {
        session()->forget('applied_voucher_id');
        return back()->with('success', 'Đã xóa mã voucher.');
    }
}
