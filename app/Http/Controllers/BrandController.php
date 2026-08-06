<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('thuong_hieu')) {
            $brands = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10, 1);
            return view('admin.brand.index', compact('brands'));
        }

        $query = Brand::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ten', 'like', "%{$search}%")
                  ->orWhere('mo_ta', 'like', "%{$search}%");
            });
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $brands = $query->latest()->paginate(10)->withQueryString();
        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        if (!Schema::hasTable('thuong_hieu')) {
            return redirect()->back()->with('error', 'Vui lòng chạy migration để tạo bảng thương hiệu trước.');
        }

        $validated = $request->validate([
            'ten'        => 'required|string|max:255',
            'slug'       => 'nullable|string|max:255|unique:thuong_hieu,slug',
            'mo_ta'      => 'nullable|string',
            'logo'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'trang_thai' => 'nullable',
        ]);

        $logo = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'brand_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            if (!is_dir(public_path('uploads/brands'))) {
                mkdir(public_path('uploads/brands'), 0755, true);
            }
            $file->move(public_path('uploads/brands'), $filename);
            $logo = 'uploads/brands/' . $filename;
        }

        $slug = !empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['ten']);

        Brand::create([
            'ten'        => $validated['ten'],
            'slug'       => $slug,
            'mo_ta'      => $validated['mo_ta'] ?? null,
            'logo'       => $logo,
            'trang_thai' => $request->has('trang_thai') ? (bool)$request->trang_thai : true,
        ]);

        return redirect()->route('brand.index')->with('success', 'Thêm thương hiệu thành công!');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        if (!Schema::hasTable('thuong_hieu')) {
            return redirect()->back()->with('error', 'Vui lòng chạy migration để tạo bảng thương hiệu trước.');
        }

        $brand = Brand::findOrFail($id);

        $validated = $request->validate([
            'ten'        => 'required|string|max:255',
            'slug'       => 'nullable|string|max:255|unique:thuong_hieu,slug,' . $brand->id,
            'mo_ta'      => 'nullable|string',
            'logo'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'trang_thai' => 'nullable',
        ]);

        $logo = $brand->logo;

        if ($request->has('remove_logo') && $request->remove_logo) {
            if ($brand->logo && file_exists(public_path($brand->logo))) {
                @unlink(public_path($brand->logo));
            }
            $logo = null;
        }

        if ($request->hasFile('logo')) {
            if ($brand->logo && file_exists(public_path($brand->logo))) {
                @unlink(public_path($brand->logo));
            }
            $file = $request->file('logo');
            $filename = 'brand_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            if (!is_dir(public_path('uploads/brands'))) {
                mkdir(public_path('uploads/brands'), 0755, true);
            }
            $file->move(public_path('uploads/brands'), $filename);
            $logo = 'uploads/brands/' . $filename;
        }

        $slug = !empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['ten']);

        $brand->update([
            'ten'        => $validated['ten'],
            'slug'       => $slug,
            'mo_ta'      => $validated['mo_ta'] ?? null,
            'logo'       => $logo,
            'trang_thai' => $request->has('trang_thai') ? (bool)$request->trang_thai : true,
        ]);

        return redirect()->route('brand.index')->with('success', 'Cập nhật thương hiệu thành công!');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->products()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa thương hiệu này vì có sản phẩm đang sử dụng!');
        }

        if ($brand->logo && file_exists(public_path($brand->logo))) {
            @unlink(public_path($brand->logo));
        }

        $brand->delete();

        return redirect()->route('brand.index')->with('success', 'Xóa thương hiệu thành công!');
    }
}
