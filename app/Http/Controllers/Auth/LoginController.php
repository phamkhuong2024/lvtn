<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\NhanVien;
use App\Models\KhachHang;

class LoginController extends Controller
{
    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Try to authenticate as Admin
        $admin = Admin::where('email', $email)->first();
        if ($admin && Hash::check($password, $admin->matkhau)) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!');
        }

        // Try to authenticate as NhanVien
        $nhanvien = NhanVien::where('email', $email)->first();
        if ($nhanvien && Hash::check($password, $nhanvien->matkhau)) {
            Auth::guard('nhanvien')->login($nhanvien);
            return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!');
        }

        // Try to authenticate as KhachHang
        $khachhang = KhachHang::where('email', $email)->first();
        if ($khachhang && Hash::check($password, $khachhang->matkhau)) {
            Auth::guard('khachhang')->login($khachhang);
            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        }

        // If no match found
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->withInput($request->only('email'));
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        // Logout from all guards
        Auth::guard('admin')->logout();
        Auth::guard('nhanvien')->logout();
        Auth::guard('khachhang')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }
}
