<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show admin profile page
     */
    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'tenad' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email,' . $admin->id,
            'matkhau' => 'nullable|min:6|confirmed',
        ]);

        $admin->tenad = $request->tenad;
        $admin->email = $request->email;

        if ($request->filled('matkhau')) {
            $admin->matkhau = Hash::make($request->matkhau);
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Cập nhật thông tin thành công!');
    }
}
