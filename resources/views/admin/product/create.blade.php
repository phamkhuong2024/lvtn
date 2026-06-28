<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col">
                <h2>Thêm sản phẩm mới</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('product.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('product.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="danhmucid" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select @error('danhmucid') is-invalid @enderror" id="danhmucid" name="danhmucid" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('danhmucid') == $category->id ? 'selected' : '' }}>{{ $category->ten }}</option>
                            @endforeach
                        </select>
                        @error('danhmucid')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten') is-invalid @enderror" id="ten" name="ten" value="{{ old('ten') }}" required>
                        @error('ten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="giaban" class="form-label">Giá bán <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('giaban') is-invalid @enderror" id="giaban" name="giaban" value="{{ old('giaban') }}" required>
                            @error('giaban')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="giagiam" class="form-label">Giá giảm</label>
                            <input type="number" step="0.01" class="form-control @error('giagiam') is-invalid @enderror" id="giagiam" name="giagiam" value="{{ old('giagiam') }}">
                            @error('giagiam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="hinhanh" class="form-label">Đường dẫn hình ảnh</label>
                        <input type="text" class="form-control @error('hinhanh') is-invalid @enderror" id="hinhanh" name="hinhanh" value="{{ old('hinhanh') }}">
                        @error('hinhanh')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mota" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('mota') is-invalid @enderror" id="mota" name="mota" rows="4">{{ old('mota') }}</textarea>
                        @error('mota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="noibat" name="noibat" value="1" {{ old('noibat') ? 'checked' : '' }}>
                                <label class="form-check-label" for="noibat">Nổi bật</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="trangthai" name="trangthai" value="1" checked>
                                <label class="form-check-label" for="trangthai">Hiển thị trên cửa hàng</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('product.index') }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
