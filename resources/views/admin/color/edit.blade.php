@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0"><i class="fas fa-edit"></i> Chỉnh sửa màu sắc</h4>
    </div>
    <div class="card-body">
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

        <form action="{{ route('color.update', $color->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="ten" class="form-label fw-bold">
                    <i class="fas fa-tag"></i> Tên màu <span class="text-danger">*</span>
                </label>
                <input type="text" 
                       class="form-control form-control-lg @error('ten') is-invalid @enderror" 
                       id="ten" 
                       name="ten" 
                       value="{{ old('ten', $color->ten) }}" 
                       placeholder="Ví dụ: Đỏ, Xanh dương, Vàng chanh..."
                       required>
                @error('ten')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="ma_mau" class="form-label fw-bold">
                    <i class="fas fa-palette"></i> Mã màu <span class="text-danger">*</span>
                </label>
                <div class="row g-2">
                    <div class="col-md-3">
                        <input type="color" 
                               class="form-control form-control-color form-control-lg @error('ma_mau') is-invalid @enderror" 
                               id="ma_mau_picker" 
                               value="{{ old('ma_mau', $color->ma_mau) }}" 
                               style="width: 100%; height: 56px;"
                               title="Chọn màu">
                    </div>
                    <div class="col-md-9">
                        <input type="text" 
                               class="form-control form-control-lg @error('ma_mau') is-invalid @enderror" 
                               id="ma_mau" 
                               name="ma_mau" 
                               value="{{ old('ma_mau', $color->ma_mau) }}" 
                               placeholder="#000000" 
                               pattern="^#[0-9A-Fa-f]{6}$"
                               required>
                        @error('ma_mau')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> Chọn màu từ bảng màu hoặc nhập mã hex (ví dụ: #FF0000 cho màu đỏ)
                </small>
            </div>

            <!-- Color Preview -->
            <div class="mb-4">
                <label class="form-label fw-bold">
                    <i class="fas fa-eye"></i> Xem trước màu sắc
                </label>
                <div class="card">
                    <div class="card-body text-center">
                        <div id="color_preview" 
                             style="width: 100%; height: 100px; background-color: {{ old('ma_mau', $color->ma_mau) }}; 
                                    border: 3px solid #dee2e6; border-radius: 10px; 
                                    transition: background-color 0.3s ease;">
                        </div>
                        <p class="mt-2 mb-0">
                            <strong>Tên:</strong> <span id="preview_name">{{ old('ten', $color->ten) }}</span><br>
                            <strong>Mã:</strong> <code id="preview_code">{{ old('ma_mau', $color->ma_mau) }}</code>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Color Info -->
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle"></i> <strong>Thông tin:</strong> 
                Màu sắc này được tạo ngày {{ $color->created_at->format('d/m/Y H:i') }}
                @if($color->updated_at != $color->created_at)
                    và được cập nhật lần cuối ngày {{ $color->updated_at->format('d/m/Y H:i') }}
                @endif
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning btn-lg">
                    <i class="fas fa-save"></i> Cập nhật màu sắc
                </button>
                <a href="{{ route('color.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <a href="{{ route('color.create') }}" class="btn btn-success btn-lg ms-auto">
                    <i class="fas fa-plus"></i> Thêm màu mới
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Sync color picker with text input and update preview
    const colorPicker = document.getElementById('ma_mau_picker');
    const colorInput = document.getElementById('ma_mau');
    const colorPreview = document.getElementById('color_preview');
    const previewCode = document.getElementById('preview_code');
    const nameInput = document.getElementById('ten');
    const previewName = document.getElementById('preview_name');
    
    // Update text input and preview when color picker changes
    colorPicker.addEventListener('input', function() {
        const color = this.value.toUpperCase();
        colorInput.value = color;
        colorPreview.style.backgroundColor = color;
        previewCode.textContent = color;
    });
    
    // Update color picker and preview when text input changes
    colorInput.addEventListener('input', function() {
        const color = this.value;
        if (color.match(/^#[0-9A-Fa-f]{6}$/)) {
            colorPicker.value = color;
            colorPreview.style.backgroundColor = color;
            previewCode.textContent = color.toUpperCase();
        }
    });
    
    // Update preview name when name input changes
    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value || 'Tên màu';
    });
</script>

@endsection
