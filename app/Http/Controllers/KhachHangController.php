<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KhachHangController extends Controller
{
    /**
     * Show list of all khach hang
     */
    public function index(Request $request)
    {
        $query = KhachHang::query();

        $purchaseSubquery = DonHang::selectRaw('COALESCE(SUM(chi_tiet_don_hang.soluong), 0)')
            ->join('chi_tiet_don_hang', 'chi_tiet_don_hang.donhangid', '=', 'don_hang.id')
            ->whereColumn('don_hang.khachhangid', 'khach_hang.id');

        $query->select('khach_hang.*')
            ->selectSub($purchaseSubquery, 'total_items_purchased');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ten', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('tendangnhap', 'like', "%{$search}%")
                  ->orWhere('sdt', 'like', "%{$search}%")
                  ->orWhere('diachi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('min_items')) {
            $minItems = (int) $request->min_items;
            $query->havingRaw('COALESCE(total_items_purchased, 0) >= ?', [$minItems]);
        }

        if ($request->filled('max_items')) {
            $maxItems = (int) $request->max_items;
            $query->havingRaw('COALESCE(total_items_purchased, 0) <= ?', [$maxItems]);
        }

        $khachhangs = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return view('khachhang.index', compact('khachhangs'));
    }

    /**
     * Show khach hang profile page
     */
    public function profile()
    {
        $khachhang = Auth::guard('khachhang')->user();
        return view('khachhang.profile', compact('khachhang'));
    }

    /**
     * Update khach hang profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('khachhang')->user();
       $khachhang = KhachHang::findOrFail($user->id);
        $request->validate([
            'ten' => 'required|string|max:255',
            'email' => 'required|email|unique:khach_hang,email,' . $khachhang->id,
            'sdt' => 'nullable|string|max:15',
            'ngaysinh' => 'nullable|date',
            'gioitinh' => 'nullable|string',
            'diachi' => 'nullable|string|max:255',
            'matkhau' => 'nullable|min:6|confirmed',
        ]);

        $khachhang->ten = $request->ten;
        $khachhang->email = $request->email;
        $khachhang->sdt = $request->sdt;
        $khachhang->ngaysinh = $request->ngaysinh;
        $khachhang->gioitinh = $request->gioitinh;
        $khachhang->diachi = $request->diachi;

        if ($request->filled('matkhau')) {
            $khachhang->matkhau = Hash::make($request->matkhau);
        }

        $khachhang->save();

        return redirect()->route('khachhang.profile')->with('success', 'Cập nhật thông tin thành công!');
    }

}
