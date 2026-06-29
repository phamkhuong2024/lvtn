<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\NhanVien;

class NhanVienController extends Controller
{
    /**
     * Display a listing of nhan vien
     */
    public function index()
    {
        $nhanviens = NhanVien::orderBy('created_at', 'desc')->paginate(10);
        return view('nhanvien.index', compact('nhanviens'));
    }

    /**
     * Show the form for creating a new nhan vien
     */
    public function create()
    {
        return view('nhanvien.create');
    }

    /**
     * Store a newly created nhan vien in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'tennv' => 'required|string|max:255',
            'email' => 'required|email|unique:nhan_vien,email',
            'sdt' => 'nullable|string|max:15',
            'matkhau' => 'required|min:6',
            'gioitinh' => 'nullable|string',
            'diachi' => 'nullable|string|max:255',
            'chucvu' => 'nullable|string|max:100',
            'ngayvaolam' => 'nullable|date',
        ]);

        NhanVien::create([
            'tennv' => $request->tennv,
            'email' => $request->email,
            'sdt' => $request->sdt,
            'matkhau' => Hash::make($request->matkhau),
            'gioitinh' => $request->gioitinh,
            'diachi' => $request->diachi,
            'chucvu' => $request->chucvu,
            'ngayvaolam' => $request->ngayvaolam ?? now(),
        ]);

        return redirect()->route('nhanvien.index')->with('success', 'Thêm nhân viên thành công!');
    }

    /**
     * Show the form for editing the specified nhan vien
     */
    public function edit($id)
    {
        $nhanvien = NhanVien::findOrFail($id);
        return view('nhanvien.edit', compact('nhanvien'));
    }

    /**
     * Update the specified nhan vien in storage
     */
    public function update(Request $request, $id)
    {
        $nhanvien = NhanVien::findOrFail($id);

        $request->validate([
            'tennv' => 'required|string|max:255',
            'email' => 'required|email|unique:nhan_vien,email,' . $id,
            'sdt' => 'nullable|string|max:15',
            'matkhau' => 'nullable|min:6',
            'gioitinh' => 'nullable|string',
            'diachi' => 'nullable|string|max:255',
            'chucvu' => 'nullable|string|max:100',
            'ngayvaolam' => 'nullable|date',
        ]);

        $nhanvien->tennv = $request->tennv;
        $nhanvien->email = $request->email;
        $nhanvien->sdt = $request->sdt;
        $nhanvien->gioitinh = $request->gioitinh;
        $nhanvien->diachi = $request->diachi;
        $nhanvien->chucvu = $request->chucvu;
        $nhanvien->ngayvaolam = $request->ngayvaolam;

        if ($request->filled('matkhau')) {
            $nhanvien->matkhau = Hash::make($request->matkhau);
        }

        $nhanvien->save();

        return redirect()->route('nhanvien.index')->with('success', 'Cập nhật nhân viên thành công!');
    }

    /**
     * Remove the specified nhan vien from storage
     */
    public function destroy($id)
    {
        $nhanvien = NhanVien::findOrFail($id);
        $nhanvien->delete();

        return redirect()->route('nhanvien.index')->with('success', 'Xóa nhân viên thành công!');
    }

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
