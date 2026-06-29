<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'ten' => ['required', 'string', 'max:255'],
            'tendangnhap' => ['required', 'string', 'max:255', 'unique:khach_hang,tendangnhap'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:khach_hang,email'],
            'sdt' => ['nullable', 'string', 'max:20'],
            'matkhau' => ['required', 'confirmed', Password::min(6)],
            'ngaysinh' => ['nullable', 'date'],
            'gioitinh' => ['nullable', 'in:Nam,Nữ,Khác'],
            'diachi' => ['nullable', 'string', 'max:500'],
        ]);

        $khachHang = KhachHang::create([
            'ten' => $validated['ten'],
            'tendangnhap' => $validated['tendangnhap'],
            'email' => $validated['email'],
            'sdt' => $validated['sdt'] ?? null,
            'matkhau' => Hash::make($validated['matkhau']),
            'ngaysinh' => $validated['ngaysinh'] ?? null,
            'gioitinh' => $validated['gioitinh'] ?? null,
            'diachi' => $validated['diachi'] ?? null,
        ]);

        // Log the user in after registration
        Auth::guard('khachhang')->login($khachHang);

        return redirect()->route('home')->with('success', 'Đăng ký thành công!');
    }
}
