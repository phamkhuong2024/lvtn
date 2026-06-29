@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col">
                <h2>Thêm danh mục mới</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('category.index') }}" class="btn btn-info text-white">Quay lại</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten') is-invalid @enderror"
                               id="ten" name="ten" value="{{ old('ten') }}" required>
                        @error('ten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mota" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('mota') is-invalid @enderror"
                                  id="mota" name="mota" rows="4">{{ old('mota') }}</textarea>
                        @error('mota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('category.index') }}" class="btn btn-warning">Hủy</a>
                        <button type="submit" class="btn btn-success">Lưu danh mục</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
