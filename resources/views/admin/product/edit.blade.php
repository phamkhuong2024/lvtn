@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col">
                <h2>Chỉnh sửa sản phẩm</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('product.index') }}" class="btn btn-info text-white">Quay lại</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('product.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="danhmucid" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select @error('danhmucid') is-invalid @enderror" id="danhmucid" name="danhmucid" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('danhmucid', $product->danhmucid) == $category->id ? 'selected' : '' }}>{{ $category->ten }}</option>
                            @endforeach
                        </select>
                        @error('danhmucid')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten') is-invalid @enderror" id="ten" name="ten" value="{{ old('ten', $product->ten) }}" required>
                        @error('ten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="giaban" class="form-label">Giá bán <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('giaban') is-invalid @enderror" id="giaban" name="giaban" value="{{ old('giaban', $product->giaban) }}" required>
                            @error('giaban')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="giagiam" class="form-label">Giá giảm</label>
                            <input type="number" step="0.01" class="form-control @error('giagiam') is-invalid @enderror" id="giagiam" name="giagiam" value="{{ old('giagiam', $product->giagiam) }}">
                            @error('giagiam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="hinhanh" class="form-label">Đường dẫn hình ảnh</label>
                        <input type="text" class="form-control @error('hinhanh') is-invalid @enderror" id="hinhanh" name="hinhanh" value="{{ old('hinhanh', $product->hinhanh) }}">
                        @error('hinhanh')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mota" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('mota') is-invalid @enderror" id="mota" name="mota" rows="4">{{ old('mota', $product->mota) }}</textarea>
                        @error('mota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="noibat" name="noibat" value="1" {{ old('noibat', $product->noibat) ? 'checked' : '' }}>
                                <label class="form-check-label" for="noibat">Nổi bật</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="trangthai" name="trangthai" value="1" {{ old('trangthai', $product->trangthai) ? 'checked' : '' }}>
                                <label class="form-check-label" for="trangthai">Hiển thị trên cửa hàng</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('product.index') }}" class="btn btn-warning">Hủy</a>
                        <button type="submit" class="btn btn-success">Cập nhật sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
