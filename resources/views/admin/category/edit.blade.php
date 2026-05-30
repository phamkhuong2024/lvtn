<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col">
                <h2>Chỉnh sửa danh mục</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('category.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('category.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="ten_danh_muc" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten_danh_muc') is-invalid @enderror" 
                               id="ten_danh_muc" name="ten_danh_muc" 
                               value="{{ old('ten_danh_muc', $category->ten_danh_muc) }}" required>
                        @error('ten_danh_muc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mo_ta" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('mo_ta') is-invalid @enderror" 
                                  id="mo_ta" name="mo_ta" rows="4">{{ old('mo_ta', $category->mo_ta) }}</textarea>
                        @error('mo_ta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('category.index') }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-primary">Cập nhật danh mục</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
