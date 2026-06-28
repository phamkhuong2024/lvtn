<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class NhanVienController extends Controller
{
    /**
     * Show nhan vien profile page
     */
    public function profile()
    {
        $nhanvien = Auth::guard('nhanvien')->user();
        return view('nhanvien.profile', compact('nhanvien'));
    }

    /**
     * Update nhan vien profile
     */
    public function updateProfile(Request $request)
    {
        $nhanvien = Auth::guard('nhanvien')->user();

        $request->validate([
            'tennv' => 'required|string|max:255',
            'email' => 'required|email|unique:nhan_vien,email,' . $nhanvien->id,
            'sdt' => 'nullable|string|max:15',
            'gioitinh' => 'nullable|string',
            'diachi' => 'nullable|string|max:255',
            'matkhau' => 'nullable|min:6|confirmed',
        ]);

        $nhanvien->tennv = $request->tennv;
        $nhanvien->email = $request->email;
        $nhanvien->sdt = $request->sdt;
        $nhanvien->gioitinh = $request->gioitinh;
        $nhanvien->diachi = $request->diachi;

        if ($request->filled('matkhau')) {
            $nhanvien->matkhau = Hash::make($request->matkhau);
        }

        $nhanvien->save();

        return redirect()->route('nhanvien.profile')->with('success', 'Cập nhật thông tin thành công!');
    }
}
