<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VoucherController extends Controller
{
    /**
     * Display vouchers for customers
     */
    public function index()
    {
        $vouchers = Voucher::where('trangthai', true)
            ->where('ngaybatdau', '<=', now())
            ->where('ngayketthuc', '>=', now())
            ->latest()
            ->get();

        return view('vouchers.index', compact('vouchers'));
    }

    /**
     * Apply voucher to cart
     */
    public function apply(Request $request)
    {
        $request->validate([
            'voucher_id' => 'required|exists:khuyen_mai,id'
        ]);

        $voucher = Voucher::find($request->voucher_id);

        if (!$voucher->isActive()) {
            return back()->with('error', 'Mã giảm giá không còn hiệu lực.');
        }

        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        if (!$voucher->isApplicable($total)) {
            $minOrder = number_format($voucher->giatridonhang, 0, ',', '.');
            return back()->with('error', "Đơn hàng tối thiểu {$minOrder}đ để áp dụng mã này.");
        }

        Session::put('voucher', [
            'id' => $voucher->id,
            'ten' => $voucher->ten,
            'discount' => $voucher->calculateDiscount($total)
        ]);

        return back()->with('success', 'Áp dụng mã giảm giá thành công!');
    }

    /**
     * Remove voucher from cart
     */
    public function remove()
    {
        Session::forget('voucher');
        return back()->with('success', 'Đã xóa mã giảm giá.');
    }

    /**
     * Display vouchers for admin/staff
     */
    public function adminIndex()
    {
        $vouchers = Voucher::latest()->paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    /**
     * Show form to create new voucher
     */
    public function create()
    {
        return view('admin.vouchers.create');
    }

    /**
     * Store new voucher
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten' => 'required|string|max:255',
            'loai_khuyen_mai' => 'required|in:phan_tram,so_tien',
            'giatrigiam' => 'required|numeric|min:0',
            'giatridonhang' => 'nullable|numeric|min:0',
            'ngaybatdau' => 'required|date',
            'ngayketthuc' => 'required|date|after_or_equal:ngaybatdau',
            'trangthai' => 'boolean',
        ]);

        if ($validated['loai_khuyen_mai'] === 'phan_tram' && $validated['giatrigiam'] > 100) {
            return back()->with('error', 'Giá trị giảm phần trăm không được vượt quá 100%.')
                ->withInput();
        }

        $validated['trangthai'] = $request->has('trangthai');

        Voucher::create($validated);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Tạo mã giảm giá thành công!');
    }

    /**
     * Show form to edit voucher
     */
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    /**
     * Update voucher
     */
    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $validated = $request->validate([
            'ten' => 'required|string|max:255',
            'loai_khuyen_mai' => 'required|in:phan_tram,so_tien',
            'giatrigiam' => 'required|numeric|min:0',
            'giatridonhang' => 'nullable|numeric|min:0',
            'ngaybatdau' => 'required|date',
            'ngayketthuc' => 'required|date|after_or_equal:ngaybatdau',
            'trangthai' => 'boolean',
        ]);

        if ($validated['loai_khuyen_mai'] === 'phan_tram' && $validated['giatrigiam'] > 100) {
            return back()->with('error', 'Giá trị giảm phần trăm không được vượt quá 100%.')
                ->withInput();
        }

        $validated['trangthai'] = $request->has('trangthai');

        $voucher->update($validated);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    /**
     * Delete voucher
     */
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        
        // Check if voucher is being used by any orders
        if ($voucher->donHangs()->count() > 0) {
            return back()->with('error', 'Không thể xóa mã giảm giá đang được sử dụng trong đơn hàng.');
        }

        $voucher->delete();

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Xóa mã giảm giá thành công!');
    }
}
