<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class LoginGoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Lấy thông tin user từ Google
            $googleUser = Socialite::driver('google')->user();

            // Kiểm tra khách hàng đã tồn tại với google_id
            $khachHang = KhachHang::where('google_id', $googleUser->id)->first();

            if ($khachHang) {
                // Khách hàng đã liên kết với Google, login trực tiếp
                Auth::guard('khachhang')->login($khachHang);
                return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
            }

            // Kiểm tra email đã tồn tại trong hệ thống
            $existingKhachHang = KhachHang::where('email', $googleUser->email)->first();

            if ($existingKhachHang) {
                // Email đã tồn tại, cập nhật google_id để liên kết tài khoản
                $existingKhachHang->update([
                    'google_id' => $googleUser->id,
                ]);

                Auth::guard('khachhang')->login($existingKhachHang);
                return redirect()->intended('/')->with('success', 'Tài khoản đã được liên kết với Google!');
            }

            // Tạo khách hàng mới
            $newKhachHang = KhachHang::create([
                'tendangnhap' => $googleUser->name,
                'ten' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'matkhau' => bcrypt(uniqid()),
            ]);

            Auth::guard('khachhang')->login($newKhachHang);
            return redirect()->intended('/')->with('success', 'Đăng ký thành công!');

        // } catch (Exception $e) {
        //     // Log lỗi để debug
        //     \Log::error('Google Login Error: ' . $e->getMessage());
            
        //     // Redirect về trang login với thông báo lỗi
        //     return redirect()->route('login')->with('error', 'Đã có lỗi xảy ra khi đăng nhập với Google. Vui lòng thử lại!');
        // }
        }catch (Exception $e) {
            dd($e);
        }
    }
}
