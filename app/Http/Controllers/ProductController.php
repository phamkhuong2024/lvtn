<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    public function index()
    {
        $products = Schema::hasTable('san_pham')
            ? Product::with(['category', 'type'])->latest()->paginate(10)
            : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10, 1);

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Schema::hasTable('danh_muc')
            ? Category::latest()->get()
            : collect();

        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!Schema::hasTable('san_pham') || !Schema::hasTable('danh_muc') || !Schema::hasTable('loai_san_pham')) {
            return redirect()->back()->with('error', 'Vui lòng chạy migration để tạo bảng sản phẩm trước.');
        }

        $request->validate([
            'danhmucid' => 'required|exists:danh_muc,id',
            'ten' => 'required|string|max:255',
            'giaban' => 'required|numeric|min:0',
            'giagiam' => 'nullable|numeric|min:0',
            'hinhanh' => 'nullable|string|max:255',
            'mota' => 'nullable|string',
            'noibat' => 'nullable|boolean',
            'trangthai' => 'nullable|boolean',
        ]);

        $productType = ProductType::firstOrCreate(
            ['danhmucid' => $request->danhmucid, 'ten' => 'Mặc định'],
            ['mota' => 'Loại mặc định được tạo tự động', 'noibat' => false]
        );

        Product::create([
            'danhmucid' => $request->danhmucid,
            'loaisanphamid' => $productType->id,
            'ten' => $request->ten,
            'giaban' => $request->giaban,
            'giagiam' => $request->giagiam,
            'hinhanh' => $request->hinhanh,
            'mota' => $request->mota,
            'noibat' => $request->boolean('noibat'),
            'trangthai' => $request->boolean('trangthai', true),
        ]);

        return redirect()->route('product.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Schema::hasTable('danh_muc')
            ? Category::latest()->get()
            : collect();

        return view('admin.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (!Schema::hasTable('san_pham') || !Schema::hasTable('danh_muc') || !Schema::hasTable('loai_san_pham')) {
            return redirect()->back()->with('error', 'Vui lòng chạy migration để tạo bảng sản phẩm trước.');
        }

        $request->validate([
            'danhmucid' => 'required|exists:danh_muc,id',
            'ten' => 'required|string|max:255',
            'giaban' => 'required|numeric|min:0',
            'giagiam' => 'nullable|numeric|min:0',
            'hinhanh' => 'nullable|string|max:255',
            'mota' => 'nullable|string',
            'noibat' => 'nullable|boolean',
            'trangthai' => 'nullable|boolean',
        ]);

        $product = Product::findOrFail($id);
        $productType = ProductType::firstOrCreate(
            ['danhmucid' => $request->danhmucid, 'ten' => 'Mặc định'],
            ['mota' => 'Loại mặc định được tạo tự động', 'noibat' => false]
        );

        $product->update([
            'danhmucid' => $request->danhmucid,
            'loaisanphamid' => $productType->id,
            'ten' => $request->ten,
            'giaban' => $request->giaban,
            'giagiam' => $request->giagiam,
            'hinhanh' => $request->hinhanh,
            'mota' => $request->mota,
            'noibat' => $request->boolean('noibat'),
            'trangthai' => $request->boolean('trangthai', true),
        ]);

        return redirect()->route('product.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
