<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KhachHangController extends Controller
{
    /**
     * Show list of all khach hang
     */
    public function index()
    {
        $khachhangs = \App\Models\KhachHang::orderBy('id', 'desc')->paginate(10);
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
        $khachhang = Auth::guard('khachhang')->user();

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
