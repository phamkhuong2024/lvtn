<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductType;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('san_pham')) {
            $products = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10, 1);
            return view('admin.product.index', compact('products'));
        }

        $query = Product::with(['category', 'type']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ten', 'like', "%{$search}%")
                  ->orWhere('mota', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('ten', 'like', "%{$search}%");
                  })
                  ->orWhereHas('type', function($q) use ($search) {
                      $q->where('ten', 'like', "%{$search}%");
                  });
            });
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Schema::hasTable('danh_muc')
            ? Category::latest()->get()
            : collect();
        
        $colors = Schema::hasTable('mau_sac') ? Color::all() : collect();
        $sizes = Schema::hasTable('kich_co') ? Size::all() : collect();

        return view('admin.product.create', compact('categories', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'danhmucid' => 'required|exists:danh_muc,id',
            'loaisanphamid' => 'required|exists:loai_san_pham,id',
            'ten' => 'required|string|max:255',
            'giaban' => 'required|numeric|min:0',
            'giagiam' => 'nullable|numeric|min:0',
            'hinhanh' => 'nullable|image|max:2048',
            'mota' => 'nullable|string',
            'noibat' => 'boolean',
            'trangthai' => 'boolean',
            'colors' => 'required|array',
            'colors.*.id' => 'required|exists:mau_sac,id',
            'colors.*.images' => 'required|array',
            'colors.*.images.*' => 'image|max:2048',
            'variants' => 'required|array',
            'variants.*.mausacid' => 'required|exists:mau_sac,id',
            'variants.*.kichcoid' => 'required|exists:kich_co,id',
            'variants.*.soluong' => 'required|integer|min:0',
            'variants.*.gia' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $productData = [
                'danhmucid' => $validated['danhmucid'],
                'loaisanphamid' => $validated['loaisanphamid'],
                'ten' => $validated['ten'],
                'giaban' => $validated['giaban'],
                'giagiam' => $validated['giagiam'] ?? null,
                'mota' => $validated['mota'] ?? null,
                'noibat' => $request->has('noibat'),
                'trangthai' => $request->has('trangthai'),
            ];

            if ($request->hasFile('hinhanh')) {
                try {
                    $uploadedFile = Cloudinary::uploadApi()->upload(
                        $request->file('hinhanh')->getRealPath(),
                        ['verify' => false]
                    );
                    $productData['hinhanh'] = $uploadedFile['secure_url'];
                } catch (\Exception $e) {
                    DB::rollback();
                    return back()->withInput()->with('error', 'Lỗi tải ảnh lên: ' . $e->getMessage());
                }
            }

            $product = Product::create($productData);

            if ($request->has('colors')) {
                foreach ($request->colors as $colorData) {
                    if (isset($colorData['images'])) {
                        foreach ($colorData['images'] as $image) {
                            try {
                                $uploadedFile = Cloudinary::uploadApi()->upload(
                                    $image->getRealPath(),
                                    ['verify' => false]
                                );
                                ProductImage::create([
                                    'sanphamid' => $product->id,
                                    'mausacid' => $colorData['id'],
                                    'hinhanh' => $uploadedFile['secure_url'],
                                    'public_id' => $uploadedFile['public_id'],
                                ]);
                            } catch (\Exception $e) {
                                DB::rollback();
                                return back()->withInput()->with('error', 'Lỗi tải ảnh màu lên: ' . $e->getMessage());
                            }
                        }
                    }
                }
            }

            if ($request->has('variants')) {
                foreach ($request->variants as $variant) {
                    ProductVariant::create([
                        'sanphamid' => $product->id,
                        'mausacid' => $variant['mausacid'],
                        'kichcoid' => $variant['kichcoid'],
                        'soluong' => $variant['soluong'],
                        'gia' => $variant['gia'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('product.index')->with('success', 'Sản phẩm đã được tạo thành công!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = Product::with(['category', 'type', 'variants.mauSac', 'variants.kichCo', 'images.mauSac'])
            ->findOrFail($id);
        
        $categories = Schema::hasTable('danh_muc') ? Category::all() : collect();
        $productTypes = Schema::hasTable('loai_san_pham') 
            ? ProductType::where('danhmucid', $product->danhmucid)->get() 
            : collect();
        $colors = Schema::hasTable('mau_sac') ? Color::all() : collect();
        $sizes = Schema::hasTable('kich_co') ? Size::all() : collect();

        return view('admin.product.edit', compact('product', 'categories', 'productTypes', 'colors', 'sizes'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'danhmucid' => 'required|exists:danh_muc,id',
            'loaisanphamid' => 'required|exists:loai_san_pham,id',
            'ten' => 'required|string|max:255',
            'giaban' => 'required|numeric|min:0',
            'giagiam' => 'nullable|numeric|min:0',
            'hinhanh' => 'nullable|image|max:2048',
            'mota' => 'nullable|string',
            'noibat' => 'boolean',
            'trangthai' => 'boolean',
            'colors' => 'required|array',
            'colors.*.id' => 'required|exists:mau_sac,id',
            'colors.*.images' => 'nullable|array',
            'colors.*.images.*' => 'image|max:2048',
            'variants' => 'required|array',
            'variants.*.mausacid' => 'required|exists:mau_sac,id',
            'variants.*.kichcoid' => 'required|exists:kich_co,id',
            'variants.*.soluong' => 'required|integer|min:0',
            'variants.*.gia' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $productData = [
                'danhmucid' => $validated['danhmucid'],
                'loaisanphamid' => $validated['loaisanphamid'],
                'ten' => $validated['ten'],
                'giaban' => $validated['giaban'],
                'giagiam' => $validated['giagiam'] ?? null,
                'mota' => $validated['mota'] ?? null,
                'noibat' => $request->has('noibat'),
                'trangthai' => $request->has('trangthai'),
            ];

            if ($request->hasFile('hinhanh')) {
                try {
                    $uploadedFile = Cloudinary::uploadApi()->upload(
                        $request->file('hinhanh')->getRealPath(),
                        ['verify' => false]
                    );
                    $productData['hinhanh'] = $uploadedFile['secure_url'];
                } catch (\Exception $e) {
                    DB::rollback();
                    return back()->withInput()->with('error', 'Lỗi tải ảnh lên: ' . $e->getMessage());
                }
            }

            $product->update($productData);
            // Delete images for colors not provided in the request
            $requestColorIds = collect($request->colors)
            ->pluck('id')
            ->toArray();
           ProductImage::where('sanphamid', $product->id)
            ->whereNotIn('mausacid', $requestColorIds)
            ->delete();
            // Update images per color
            if ($request->has('colors')) {
                foreach ($request->colors as $colorData) {
                    // Only update images for this color if new images are provided
                    if (isset($colorData['images']) && !empty($colorData['images'])) {
                        // Delete old images for this specific color only
                        $product->images()->where('mausacid', $colorData['id'])->delete();

                        // Create new images for this color
                        foreach ($colorData['images'] as $image) {
                            try {
                                $uploadedFile = Cloudinary::uploadApi()->upload(
                                    $image->getRealPath(),
                                    ['verify' => false]
                                );
                                ProductImage::create([
                                    'sanphamid' => $product->id,    
                                    'mausacid' => $colorData['id'],
                                    'hinhanh' => $uploadedFile['secure_url'],
                                    'public_id' => $uploadedFile['public_id'],
                                ]);
                            } catch (\Exception $e) {
                                DB::rollback();
                                return back()->withInput()->with('error', 'Lỗi tải ảnh màu lên: ' . $e->getMessage());
                            }
                        }
                    }
                    // If no new images for this color, keep existing images
                }
            }

            // Always recreate variants
            $product->variants()->delete();

            if ($request->has('variants')) {
                foreach ($request->variants as $variant) {
                    ProductVariant::create([
                        'sanphamid' => $product->id,
                        'mausacid' => $variant['mausacid'],
                        'kichcoid' => $variant['kichcoid'],
                        'soluong' => $variant['soluong'],
                        'gia' => $variant['gia'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('product.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function getProductTypes($categoryId)
    {
        $productTypes = ProductType::where('danhmucid', $categoryId)->get();
        return response()->json($productTypes);
    }

    public function show($id)
    {
        $product = Product::with([
            'category', 
            'type', 
            'images.mauSac', 
            'variants.mauSac', 
            'variants.kichCo'
        ])->findOrFail($id);
        
        // Get unique colors from variants
        $colors = $product->variants->pluck('mauSac')->unique('id')->values();
        
        // Get unique sizes from variants
        $sizes = $product->variants->pluck('kichCo')->unique('id')->values();
        
        // Group images by color
        $imagesByColor = $product->images->groupBy('mausacid');
        
        return view('sanpham.detail', compact('product', 'colors', 'sizes', 'imagesByColor'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Sản phẩm đã được xóa thành công!');
    }
}
