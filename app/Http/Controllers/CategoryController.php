<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_danh_muc' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
        ]);

        Category::create([
            'ten_danh_muc' => $request->ten_danh_muc,
            'mo_ta' => $request->mo_ta,
        ]);

        return redirect()->route('category.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ten_danh_muc' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'ten_danh_muc' => $request->ten_danh_muc,
            'mo_ta' => $request->mo_ta,
        ]);

        return redirect()->route('category.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Xóa danh mục thành công!');
    }
}
