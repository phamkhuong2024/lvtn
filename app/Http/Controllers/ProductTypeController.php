<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use App\Models\Category;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of product types with search and pagination
     */
    public function index(Request $request)
    {
        $query = ProductType::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ten', 'like', "%{$search}%")
                  ->orWhere('mota', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('ten', 'like', "%{$search}%");
                  });
            });
        }

        $productTypes = $query->latest()->paginate(10)->withQueryString();
        return view('admin.producttype.index', compact('productTypes'));
    }

    /**
     * Show the form for creating a new product type
     */
    public function create()
    {
        $categories = Category::orderBy('ten')->get();
        return view('admin.producttype.create', compact('categories'));
    }

    /**
     * Store a newly created product type in database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'danhmucid' => 'required|exists:danh_muc,id',
            'ten' => 'required|string|max:255',
            'mota' => 'nullable|string',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'noibat' => 'boolean',
        ], [
            'danhmucid.required' => 'Danh mục là bắt buộc',
            'danhmucid.exists' => 'Danh mục không tồn tại',
            'ten.required' => 'Tên loại sản phẩm là bắt buộc',
            'ten.max' => 'Tên loại sản phẩm không được vượt quá 255 ký tự',
            'hinhanh.image' => 'File phải là hình ảnh',
            'hinhanh.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'hinhanh.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
        ]);
        // Handle image upload to Cloudinary
        if ($request->hasFile('hinhanh')) {
            try {
                $uploadedFile = Cloudinary::uploadApi()->upload(
                $request->file('hinhanh')->getRealPath(),
                [
                    'verify' => false
                ]
);

$uploadedFileUrl = $uploadedFile['secure_url'];
                $validated['hinhanh'] = $uploadedFileUrl;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Lỗi tải ảnh lên: ' . $e->getMessage());
            }
        }

        $validated['noibat'] = $request->has('noibat') ? true : false;

        ProductType::create($validated);

        return redirect()->route('producttype.index')
            ->with('success', 'Thêm loại sản phẩm thành công!');
    }

    /**
     * Show the form for editing the specified product type
     */
    public function edit($id)
    {
        $productType = ProductType::findOrFail($id);
        $categories = Category::orderBy('ten')->get();
        return view('admin.producttype.edit', compact('productType', 'categories'));
    }

    /**
     * Update the specified product type in database
     */
    public function update(Request $request, $id)
    {
        $productType = ProductType::findOrFail($id);

        $validated = $request->validate([
            'danhmucid' => 'required|exists:danh_muc,id',
            'ten' => 'required|string|max:255',
            'mota' => 'nullable|string',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'noibat' => 'boolean',
        ], [
            'danhmucid.required' => 'Danh mục là bắt buộc',
            'danhmucid.exists' => 'Danh mục không tồn tại',
            'ten.required' => 'Tên loại sản phẩm là bắt buộc',
            'ten.max' => 'Tên loại sản phẩm không được vượt quá 255 ký tự',
            'hinhanh.image' => 'File phải là hình ảnh',
            'hinhanh.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'hinhanh.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
        ]);

        // Handle image upload to Cloudinary
        if ($request->hasFile('hinhanh')) {
            try {
                $uploadedFileUrl =  Cloudinary::upload(
    $request->file('hinhanh')->getRealPath()
)->getSecurePath();
                $validated['hinhanh'] = $uploadedFileUrl;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Lỗi tải ảnh lên: ' . $e->getMessage());
            }
        }

        $validated['noibat'] = $request->has('noibat') ? true : false;

        $productType->update($validated);

        return redirect()->route('producttype.index')
            ->with('success', 'Cập nhật loại sản phẩm thành công!');
    }

    /**
     * Remove the specified product type from database
     */
    public function destroy($id)
    {
        $productType = ProductType::findOrFail($id);
        
        // Check if product type is being used in any products
        if ($productType->products()->count() > 0) {
            return redirect()->route('producttype.index')
                ->with('error', 'Không thể xóa loại sản phẩm đang có sản phẩm!');
        }

        $productType->delete();

        return redirect()->route('producttype.index')
            ->with('success', 'Xóa loại sản phẩm thành công!');
    }
}
