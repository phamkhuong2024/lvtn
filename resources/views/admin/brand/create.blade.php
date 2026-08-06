@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h2><i class="fas fa-trademark me-2 text-primary"></i>Thêm thương hiệu mới</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('brand.index') }}" class="btn btn-info text-white">
                    <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách
                </a>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle me-2"></i>
                <strong>Có lỗi xảy ra:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin thương hiệu</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <label for="ten" class="form-label fw-bold">
                                    Tên thương hiệu <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control form-control-lg @error('ten') is-invalid @enderror"
                                       id="ten"
                                       name="ten"
                                       value="{{ old('ten') }}"
                                       required
                                       placeholder="Ví dụ: Uniqlo, Nike, Adidas...">
                                @error('ten')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="slug" class="form-label fw-bold">
                                    Slug <span class="text-muted small">(Để trống sẽ tự tạo từ tên)</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-link"></i></span>
                                    <input type="text"
                                           class="form-control @error('slug') is-invalid @enderror"
                                           id="slug"
                                           name="slug"
                                           value="{{ old('slug') }}"
                                           placeholder="ten-thuong-hieu">
                                </div>
                                @error('slug')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="mo_ta" class="form-label fw-bold">Mô tả</label>
                                <textarea class="form-control @error('mo_ta') is-invalid @enderror"
                                          id="mo_ta"
                                          name="mo_ta"
                                          rows="5"
                                          placeholder="Mô tả ngắn gọn về thương hiệu, nguồn gốc, sản phẩm chính...">{{ old('mo_ta') }}</textarea>
                                @error('mo_ta')
                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="logo" class="form-label fw-bold">Logo thương hiệu</label>
                                <div class="border rounded p-3 bg-light mb-3 text-center" style="min-height: 150px; display: flex; align-items: center; justify-content: center;">
                                    <img id="image-preview"
                                         src=""
                                         alt="Logo preview"
                                         class="img-fluid"
                                         style="max-width: 100%; max-height: 140px; object-fit: contain; display: none;">
                                    <span id="no-preview" class="text-muted">
                                        <i class="fas fa-image fa-3x mb-2 d-block opacity-50"></i>
                                        <small>Chưa có logo</small>
                                    </span>
                                </div>
                                <input type="file"
                                       class="form-control @error('logo') is-invalid @enderror"
                                       id="logo"
                                       name="logo"
                                       accept="image/*"
                                       onchange="previewImage(event)">
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Định dạng: JPG, PNG, GIF. Tối đa 2MB.
                                </small>
                                @error('logo')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="trang_thai" class="form-label fw-bold">Trạng thái</label>
                                <div class="card p-3 bg-light border">
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               role="switch"
                                               id="trang_thai"
                                               name="trang_thai"
                                               value="1"
                                               {{ old('trang_thai', '1') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="trang_thai">
                                            <span class="fw-bold">Hoạt động</span>
                                            <small class="d-block text-muted">Bật để hiển thị thương hiệu này trên website</small>
                                        </label>
                                    </div>
                                </div>
                                @error('trang_thai')
                                    <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('brand.index') }}" class="btn btn-warning px-4">
                            <i class="fas fa-times me-1"></i>Hủy
                        </a>
                        <button type="reset" class="btn btn-secondary px-4">
                            <i class="fas fa-undo me-1"></i>Đặt lại
                        </button>
                        <button type="submit" class="btn btn-success px-5">
                            <i class="fas fa-save me-1"></i>Lưu thương hiệu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('image-preview');
            const noPreview = document.getElementById('no-preview');
            output.src = reader.result;
            output.style.display = 'block';
            noPreview.style.display = 'none';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    document.getElementById('ten').addEventListener('input', function() {
        const slugInput = document.getElementById('slug');
        if (!slugInput.value || slugInput.dataset.auto === 'true') {
            slugInput.value = this.value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^\w\s-]/g, '')
                .trim()
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.dataset.auto = 'true';
        }
    });

    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.auto = 'false';
    });
</script>
@endpush

@endsection
