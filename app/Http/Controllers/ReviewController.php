<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ReviewController extends Controller
{
    /**
     * Store a new review for a product
     */
    public function store(Request $request, $id)
    {
        // Check if user is authenticated
        if (!Auth::guard('khachhang')->check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để đánh giá sản phẩm.');
        }

        // Validate the product exists
        $product = Product::findOrFail($id);

        // Validate request
        $validated = $request->validate([
            'sosao' => 'required|integer|min:1|max:5',
            'binhluan' => 'nullable|string|max:1000',
            'hinhanh' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ], [
            'sosao.required' => 'Vui lòng chọn số sao đánh giá.',
            'sosao.min' => 'Số sao tối thiểu là 1.',
            'sosao.max' => 'Số sao tối đa là 5.',
            'binhluan.max' => 'Bình luận không được vượt quá 1000 ký tự.',
            'hinhanh.image' => 'File phải là hình ảnh.',
            'hinhanh.mimes' => 'Hình ảnh phải có định dạng: jpeg, jpg, png, gif.',
            'hinhanh.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ]);

        // Check if user already reviewed this product
        $existingReview = DanhGia::where('sanphamid', $id)
            ->where('khachhangid', Auth::guard('khachhang')->id())
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        // Handle image upload if present
        $imageUrl = null;
        if ($request->hasFile('hinhanh')) {
            try {
                $uploadedFileUrl = Cloudinary::upload(
                    $request->file('hinhanh')->getRealPath(),
                    [
                        'folder' => 'reviews',
                        'transformation' => [
                            'width' => 800,
                            'height' => 800,
                            'crop' => 'limit'
                        ]
                    ]
                )->getSecurePath();
                
                $imageUrl = $uploadedFileUrl;
            } catch (\Exception $e) {
                return back()->with('error', 'Lỗi khi tải hình ảnh lên. Vui lòng thử lại.');
            }
        }

        // Create review
        DanhGia::create([
            'sanphamid' => $id,
            'khachhangid' => Auth::guard('khachhang')->id(),
            'sosao' => $validated['sosao'],
            'binhluan' => $validated['binhluan'],
            'hinhanh' => $imageUrl,
            'ngaydang' => now(),
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
