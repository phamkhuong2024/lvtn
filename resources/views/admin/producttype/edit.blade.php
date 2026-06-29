@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0"><i class="fas fa-edit"></i> Chỉnh sửa loại sản phẩm</h4>
    </div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-circle"></i> Lỗi!</strong>
                <p class="mb-0 mt-2">{{ session('error') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-exclamation-triangle"></i> Có lỗi xảy ra!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('producttype.update', $productType->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="danhmucid" class="form-label fw-bold">
                    <i class="fas fa-folder"></i> Danh mục <span class="text-danger">*</span>
                </label>
                <select class="form-select form-select-lg @error('danhmucid') is-invalid @enderror" 
                        id="danhmucid" 
                        name="danhmucid" 
                        required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                                {{ old('danhmucid', $productType->danhmucid) == $category->id ? 'selected' : '' }}>
                            {{ $category->ten }}
                        </option>
                    @endforeach
                </select>
                @error('danhmucid')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="ten" class="form-label fw-bold">
                    <i class="fas fa-tag"></i> Tên loại sản phẩm <span class="text-danger">*</span>
                </label>
                <input type="text" 
                       class="form-control form-control-lg @error('ten') is-invalid @enderror" 
                       id="ten" 
                       name="ten" 
                       value="{{ old('ten', $productType->ten) }}" 
                       placeholder="Ví dụ: Áo thun, Quần jean, Váy dạ hội..."
                       required>
                @error('ten')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="mota" class="form-label fw-bold">
                    <i class="fas fa-align-left"></i> Mô tả
                </label>
                <textarea class="form-control @error('mota') is-invalid @enderror" 
                          id="mota" 
                          name="mota" 
                          rows="4" 
                          placeholder="Nhập mô tả chi tiết về loại sản phẩm này...">{{ old('mota', $productType->mota) }}</textarea>
                @error('mota')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="hinhanh" class="form-label fw-bold">
                    <i class="fas fa-image"></i> Hình ảnh
                </label>
                
                @if($productType->hinhanh)
                <div class="mb-3">
                    <label class="form-label">Hình ảnh hiện tại:</label>
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="{{ $productType->hinhanh }}" 
                                 alt="{{ $productType->ten }}" 
                                 id="current_image"
                                 style="max-width: 100%; max-height: 300px; border-radius: 8px;">
                        </div>
                    </div>
                </div>
                @endif
                
                <input type="file" 
                       class="form-control @error('hinhanh') is-invalid @enderror" 
                       id="hinhanh" 
                       name="hinhanh"
                       accept="image/*"
                       onchange="previewImage(event)">
                @error('hinhanh')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> Định dạng: jpeg, png, jpg, gif. Kích thước tối đa: 2MB. Để trống nếu không muốn thay đổi.
                </small>
                
                <!-- New Image Preview -->
                <div id="new_image_preview_container" class="mt-3" style="display: none;">
                    <label class="form-label fw-bold">
                        <i class="fas fa-eye"></i> Xem trước hình ảnh mới
                    </label>
                    <div class="card">
                        <div class="card-body text-center">
                            <img id="new_image_preview" 
                                 src="" 
                                 alt="Preview" 
                                 style="max-width: 100%; max-height: 300px; border-radius: 8px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" 
                           type="checkbox" 
                           id="noibat" 
                           name="noibat"
                           value="1"
                           {{ old('noibat', $productType->noibat) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="noibat">
                        <i class="fas fa-star"></i> Đánh dấu là nổi bật
                    </label>
                    <div class="form-text">
                        <i class="fas fa-info-circle"></i> Loại sản phẩm nổi bật sẽ được hiển thị ưu tiên trên trang chủ
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle"></i> <strong>Thông tin:</strong> 
                Loại sản phẩm này được tạo ngày {{ $productType->created_at->format('d/m/Y H:i') }}
                @if($productType->updated_at != $productType->created_at)
                    và được cập nhật lần cuối ngày {{ $productType->updated_at->format('d/m/Y H:i') }}
                @endif
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning btn-lg">
                    <i class="fas fa-save"></i> Cập nhật loại sản phẩm
                </button>
                <a href="{{ route('producttype.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <a href="{{ route('producttype.create') }}" class="btn btn-success btn-lg ms-auto">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const newPreview = document.getElementById('new_image_preview');
        const newPreviewContainer = document.getElementById('new_image_preview_container');
        const currentImage = document.getElementById('current_image');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                newPreview.src = e.target.result;
                newPreviewContainer.style.display = 'block';
                if (currentImage) {
                    currentImage.style.opacity = '0.5';
                }
            };
            reader.readAsDataURL(file);
        } else {
            newPreviewContainer.style.display = 'none';
            if (currentImage) {
                currentImage.style.opacity = '1';
            }
        }
    }
</script>

@endsection
