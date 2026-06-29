<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of colors with search and pagination
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $colors = Color::when($search, function($query) use ($search) {
            return $query->where('ten', 'like', "%{$search}%")
                        ->orWhere('ma_mau', 'like', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString();
        
        return view('admin.color.index', compact('colors', 'search'));
    }

    /**
     * Show the form for creating a new color
     */
    public function create()
    {
        return view('admin.color.create');
    }

    /**
     * Store a newly created color in database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten' => 'required|string|max:255',
            'ma_mau' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ], [
            'ten.required' => 'Tên màu là bắt buộc',
            'ten.max' => 'Tên màu không được vượt quá 255 ký tự',
            'ma_mau.required' => 'Mã màu là bắt buộc',
            'ma_mau.regex' => 'Mã màu phải có định dạng hex (#000000)',
        ]);

        Color::create($validated);

        return redirect()->route('color.index')
            ->with('success', 'Thêm màu sắc thành công!');
    }

    /**
     * Show the form for editing the specified color
     */
    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.color.edit', compact('color'));
    }

    /**
     * Update the specified color in database
     */
    public function update(Request $request, $id)
    {
        $color = Color::findOrFail($id);

        $validated = $request->validate([
            'ten' => 'required|string|max:255',
            'ma_mau' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ], [
            'ten.required' => 'Tên màu là bắt buộc',
            'ten.max' => 'Tên màu không được vượt quá 255 ký tự',
            'ma_mau.required' => 'Mã màu là bắt buộc',
            'ma_mau.regex' => 'Mã màu phải có định dạng hex (#000000)',
        ]);

        $color->update($validated);

        return redirect()->route('color.index')
            ->with('success', 'Cập nhật màu sắc thành công!');
    }

    /**
     * Remove the specified color from database
     */
    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        
        // Check if color is being used in any product variants
        if ($color->chiTietSanPhams()->count() > 0) {
            return redirect()->route('color.index')
                ->with('error', 'Không thể xóa màu sắc đang được sử dụng trong sản phẩm!');
        }

        $color->delete();

        return redirect()->route('color.index')
            ->with('success', 'Xóa màu sắc thành công!');
    }
}
