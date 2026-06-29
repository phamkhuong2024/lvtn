<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of sizes with search and pagination
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $sizes = Size::when($search, function($query) use ($search) {
            return $query->where('ten', 'like', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString();
        
        return view('admin.size.index', compact('sizes', 'search'));
    }

    /**
     * Show the form for creating a new size
     */
    public function create()
    {
        return view('admin.size.create');
    }

    /**
     * Store a newly created size in database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten' => 'required|string|max:255|unique:kich_co,ten',
        ], [
            'ten.required' => 'Tên kích cỡ là bắt buộc',
            'ten.max' => 'Tên kích cỡ không được vượt quá 255 ký tự',
            'ten.unique' => 'Tên kích cỡ đã tồn tại',
        ]);

        Size::create($validated);

        return redirect()->route('size.index')
            ->with('success', 'Thêm kích cỡ thành công!');
    }

    /**
     * Show the form for editing the specified size
     */
    public function edit($id)
    {
        $size = Size::findOrFail($id);
        return view('admin.size.edit', compact('size'));
    }

    /**
     * Update the specified size in database
     */
    public function update(Request $request, $id)
    {
        $size = Size::findOrFail($id);

        $validated = $request->validate([
            'ten' => 'required|string|max:255|unique:kich_co,ten,' . $id,
        ], [
            'ten.required' => 'Tên kích cỡ là bắt buộc',
            'ten.max' => 'Tên kích cỡ không được vượt quá 255 ký tự',
            'ten.unique' => 'Tên kích cỡ đã tồn tại',
        ]);

        $size->update($validated);

        return redirect()->route('size.index')
            ->with('success', 'Cập nhật kích cỡ thành công!');
    }

    /**
     * Remove the specified size from database
     */
    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        
        // Check if size is being used in any product variants
        if ($size->chiTietSanPhams()->count() > 0) {
            return redirect()->route('size.index')
                ->with('error', 'Không thể xóa kích cỡ đang được sử dụng trong sản phẩm!');
        }

        $size->delete();

        return redirect()->route('size.index')
            ->with('success', 'Xóa kích cỡ thành công!');
    }
}
