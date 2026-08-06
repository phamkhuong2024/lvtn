<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('danh_muc')) {
            $categories = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10, 1);
            return view('admin.category.index', compact('categories'));
        }

        $query = Category::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ten', 'like', "%{$search}%")
                  ->orWhere('mota', 'like', "%{$search}%")
                  ->when(
                      Schema::hasColumn('danh_muc', 'slug'),
                      fn ($query) => $query->orWhere('slug', 'like', "%{$search}%")
                  );
            });
        }

        $categories = $query->latest()->paginate(10)->withQueryString();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        if (!Schema::hasTable('danh_muc')) {
            return redirect()->back()->with('error', 'Vui lòng chạy migration để tạo bảng danh mục trước.');
        }

        $request->validate([
            'ten' => 'required|string|max:255',
            'mota' => 'nullable|string',
        ]);

        Category::create([
            'ten' => $request->ten,
            'mota' => $request->mota,
            'slug' => $request->input('slug'),
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
        if (!Schema::hasTable('danh_muc')) {
            return redirect()->back()->with('error', 'Vui lòng chạy migration để tạo bảng danh mục trước.');
        }

        $request->validate([
            'ten' => 'required|string|max:255',
            'mota' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'ten' => $request->ten,
            'mota' => $request->mota,
            'slug' => $request->input('slug'),
        ]);

        return redirect()->route('category.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->productTypes()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa danh mục này vì có loại sản phẩm đang sử dụng!');
        }
        
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Xóa danh mục thành công!');
    }
}
