@extends('layouts.admin')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Thêm kích cỡ mới</h4>
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

        <form action="{{ route('size.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="ten" class="form-label fw-bold">
                    <i class="fas fa-tag"></i> Tên kích cỡ <span class="text-danger">*</span>
                </label>
                <input type="text" 
                       class="form-control form-control-lg @error('ten') is-invalid @enderror" 
                       id="ten" 
                       name="ten" 
                       value="{{ old('ten') }}" 
                       placeholder="Ví dụ: S, M, L, XL, XXL, 38, 39, 40..."
                       required
                       autofocus>
                @error('ten')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> Nhập tên kích cỡ theo tiêu chuẩn (S, M, L cho quần áo hoặc số cho giày dép)
                </small>
            </div>

            <!-- Preview Section -->
            <div class="mb-4">
                <label class="form-label fw-bold">
                    <i class="fas fa-eye"></i> Xem trước
                </label>
                <div class="card">
                    <div class="card-body text-center">
                        <span class="badge bg-info text-dark fs-3 px-4 py-3" id="size_preview">
                            <span id="preview_text">{{ old('ten', 'Tên kích cỡ') }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Common Sizes Examples -->
            <div class="alert alert-info">
                <strong><i class="fas fa-lightbulb"></i> Gợi ý kích cỡ phổ biến:</strong>
                <div class="mt-2">
                    <strong>Quần áo:</strong>
                    <div class="d-flex flex-wrap gap-2 mt-1">
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="XS">XS</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="S">S</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="M">M</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="L">L</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="XL">XL</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="XXL">XXL</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="XXXL">XXXL</button>
                    </div>
                </div>
                <div class="mt-3">
                    <strong>Giày dép:</strong>
                    <div class="d-flex flex-wrap gap-2 mt-1">
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="36">36</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="37">37</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="38">38</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="39">39</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="40">40</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="41">41</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="42">42</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="43">43</button>
                        <button type="button" class="btn btn-sm btn-outline-info size-suggestion" data-size="44">44</button>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-save"></i> Lưu kích cỡ
                </button>
                <a href="{{ route('size.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Update preview when typing
    document.getElementById('ten').addEventListener('input', function() {
        const previewText = document.getElementById('preview_text');
        previewText.textContent = this.value || 'Tên kích cỡ';
    });

    // Size suggestions click handler
    document.querySelectorAll('.size-suggestion').forEach(button => {
        button.addEventListener('click', function() {
            const size = this.getAttribute('data-size');
            document.getElementById('ten').value = size;
            document.getElementById('preview_text').textContent = size;
        });
    });
</script>
@endsection
