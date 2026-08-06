@extends('layouts.admin')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-3">Thêm sản phẩm mới</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Sản phẩm</a></li>
                    <li class="breadcrumb-item active">Thêm mới</li>
                </ol>
            </nav>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Có lỗi xảy ra!</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Product Information Card -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Thông tin sản phẩm</h5>
                    </div>
                    <div class="card-body">
                        <!-- Category, Product Type, and Brand -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="danhmucid" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                <select class="form-select" id="danhmucid" name="danhmucid" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('danhmucid') == $category->id ? 'selected' : '' }}>
                                            {{ $category->ten }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="loaisanphamid" class="form-label">Loại sản phẩm <span class="text-danger">*</span></label>
                                <select class="form-select" id="loaisanphamid" name="loaisanphamid" required>
                                    <option value="">-- Chọn danh mục trước --</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="thuong_hieu_id" class="form-label">Thương hiệu</label>
                                <select class="form-select" id="thuong_hieu_id" name="thuong_hieu_id">
                                    <option value="">-- Chọn thương hiệu --</option>
                                    @foreach($brands as $b)
                                        <option value="{{ $b->id }}" {{ old('thuong_hieu_id') == $b->id ? 'selected' : '' }}>
                                            {{ $b->ten }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="ten" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="ten" name="ten" value="{{ old('ten') }}" required>
                        </div>

                        <!-- Prices -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="giaban" class="form-label">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="giaban" name="giaban" value="{{ old('giaban') }}" min="0" step="1000" required>
                            </div>
                            <div class="col-md-6">
                                <label for="giagiam" class="form-label">Giá giảm (VNĐ)</label>
                                <input type="number" class="form-control" id="giagiam" name="giagiam" value="{{ old('giagiam') }}" min="0" step="1000">
                            </div>
                        </div>

                        <!-- Main Product Image -->
                        <div class="mb-3">
                            <label for="hinhanh" class="form-label">Hình ảnh đại diện</label>
                            <input type="file" class="form-control" id="hinhanh" name="hinhanh" accept="image/*">
                            <div id="mainImagePreview" class="mt-2"></div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="mota" class="form-label">Mô tả sản phẩm</label>
                            <textarea class="form-control" id="mota" name="mota" rows="4">{{ old('mota') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Colors Section -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-palette me-2"></i>Màu sắc</h5>
                        <button type="button" class="btn btn-light btn-sm" id="addColorBtn">
                            <i class="bi bi-plus-circle me-1"></i>Thêm màu sắc
                        </button>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Chọn các màu sắc có sẵn cho sản phẩm này</p>
                        <div id="colorsList" class="mb-3">
                            <!-- Selected colors will appear here -->
                        </div>
                        
                        <!-- Color Selection Modal Trigger -->
                        <div id="colorSelectionArea" style="display: none;">
                            <label class="form-label">Chọn màu sắc</label>
                            <select class="form-select" id="colorSelect">
                                <option value="">-- Chọn màu --</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}" data-color="{{ $color->ma_mau }}">
                                        {{ $color->ten }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Sizes Section -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-rulers me-2"></i>Kích cỡ</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Chọn các kích cỡ có sẵn cho sản phẩm này</p>
                        <div class="d-flex flex-wrap gap-2" id="sizesArea">
                            @foreach($sizes as $size)
                                <div class="form-check">
                                    <input class="form-check-input size-checkbox" type="checkbox" 
                                           id="size_{{ $size->id }}" value="{{ $size->id }}" 
                                           data-size-name="{{ $size->ten }}">
                                    <label class="form-check-label" for="size_{{ $size->id }}">
                                        {{ $size->ten }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Variants Table -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-table me-2"></i>Quản lý tồn kho</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Thiết lập giá và số lượng cho từng kết hợp màu/kích cỡ</p>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="variantsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Màu / Kích cỡ</th>
                                        <th class="text-center" colspan="100" id="sizeHeaders">
                                            <span class="text-muted">Chọn màu sắc và kích cỡ để tạo bảng</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="variantsTableBody">
                                    <tr>
                                        <td colspan="100" class="text-center text-muted py-4">
                                            Vui lòng chọn màu sắc và kích cỡ ở trên
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Trạng thái</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="noibat" name="noibat" value="1" {{ old('noibat') ? 'checked' : '' }}>
                            <label class="form-check-label" for="noibat">
                                Sản phẩm nổi bật
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="trangthai" name="trangthai" value="1" {{ old('trangthai', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="trangthai">
                                Bật trên trang chủ
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2" id="submitBtn">
                            <span class="btn-text">
                                <i class="bi bi-check-circle me-2"></i>Tạo sản phẩm
                            </span>
                        </button>
                        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-circle me-2"></i>Hủy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectedColors = [];
    const selectedSizes = [];
    const colorImages = {};
    
    // Button loading state functions
    function showButtonLoading(buttonId) {
        const btn = document.getElementById(buttonId);
        btn.disabled = true;
        btn.classList.add('btn-loading');
        
        const spinner = document.createElement('span');
        spinner.className = 'btn-spinner';
        btn.appendChild(spinner);
    }
    
    function hideButtonLoading(buttonId) {
        const btn = document.getElementById(buttonId);
        btn.disabled = false;
        btn.classList.remove('btn-loading');
        
        const spinner = btn.querySelector('.btn-spinner');
        if (spinner) {
            spinner.remove();
        }
    }
    
    // Load Product Types when Category changes
    document.getElementById('danhmucid').addEventListener('change', function() {
        const categoryId = this.value;
        const productTypeSelect = document.getElementById('loaisanphamid');
        if (!categoryId) {
            productTypeSelect.disabled = true;
            productTypeSelect.innerHTML = '<option value="">-- Chọn danh mục trước --</option>';
            return;
        }
        
        productTypeSelect.disabled = true;
        productTypeSelect.innerHTML = '<option value="">Đang tải...</option>';
        
        fetch(`/admin/products/get-product-types/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                productTypeSelect.innerHTML = '<option value="">-- Chọn loại sản phẩm --</option>';
                data.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.id;
                    option.textContent = type.ten;
                    productTypeSelect.appendChild(option);
                });
                productTypeSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                productTypeSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
            });
    });
    
    // Main image preview
    document.getElementById('hinhanh').addEventListener('change', function(e) {
        const preview = document.getElementById('mainImagePreview');
        preview.innerHTML = '';
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">`;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Add Color Button Click
    document.getElementById('addColorBtn').addEventListener('click', function() {
        const colorSelectionArea = document.getElementById('colorSelectionArea');
        colorSelectionArea.style.display = colorSelectionArea.style.display === 'none' ? 'block' : 'none';
    });
    
    // Color Selection
    document.getElementById('colorSelect').addEventListener('change', function() {
        const colorId = this.value;
        const colorName = this.options[this.selectedIndex].text;
        const colorCode = this.options[this.selectedIndex].dataset.color;
        
        if (!colorId) return;
        
        // Check if already selected
        if (selectedColors.find(c => c.id == colorId)) {
            alert('Màu này đã được chọn!');
            this.value = '';
            return;
        }
        
        selectedColors.push({ id: colorId, name: colorName, color: colorCode });
        colorImages[colorId] = [];
        
        renderColorsList();
        generateVariantsTable();
        this.value = '';
        document.getElementById('colorSelectionArea').style.display = 'none';
    });
    
    // Render Colors List
    function renderColorsList() {
        const colorsList = document.getElementById('colorsList');
        
        if (selectedColors.length === 0) {
            colorsList.innerHTML = '<p class="text-muted">Chưa có màu nào được chọn</p>';
            return;
        }
        
        colorsList.innerHTML = '';
        selectedColors.forEach((color, index) => {
            const colorCard = document.createElement('div');
            colorCard.className = 'card mb-3';
            colorCard.style.borderLeft = `5px solid ${color.color}`;
            
            colorCard.innerHTML = `
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">
                            <span class="badge" style="background-color: ${color.color};">&nbsp;&nbsp;&nbsp;</span>
                            ${color.name}
                        </h6>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeColor(${color.id})">
                            <i class="bi bi-trash"></i> Xóa
                        </button>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Hình ảnh cho màu này <span class="text-danger">*</span></label>
                        <input type="file" class="form-control color-images-input" 
                               data-color-id="${color.id}" accept="image/*" multiple required>
                    </div>
                    <div class="image-preview-container d-flex flex-wrap gap-2" id="preview_${color.id}"></div>
                </div>
            `;
            
            colorsList.appendChild(colorCard);
        });
        
        // Attach image change handlers
        document.querySelectorAll('.color-images-input').forEach(input => {
            input.addEventListener('change', handleColorImagesChange);
        });
    }
    
    // Handle Color Images Change
    function handleColorImagesChange(e) {
        const colorId = e.target.dataset.colorId;
        const files = Array.from(e.target.files);
        const previewContainer = document.getElementById(`preview_${colorId}`);
        
        previewContainer.innerHTML = '';
        colorImages[colorId] = files;
        
        files.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = document.createElement('div');
                imgDiv.className = 'position-relative';
                imgDiv.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" 
                            onclick="removeColorImage(${colorId}, ${idx})" style="padding: 2px 6px;">
                        <i class="bi bi-x"></i>
                    </button>
                `;
                previewContainer.appendChild(imgDiv);
            };
            reader.readAsDataURL(file);
        });
    }
    
    // Remove Color
    window.removeColor = function(colorId) {
        const index = selectedColors.findIndex(c => c.id == colorId);
        if (index > -1) {
            selectedColors.splice(index, 1);
            delete colorImages[colorId];
            renderColorsList();
            generateVariantsTable();
        }
    };
    
    // Remove Color Image
    window.removeColorImage = function(colorId, imageIndex) {
        colorImages[colorId].splice(imageIndex, 1);
        const input = document.querySelector(`[data-color-id="${colorId}"]`);
        const dt = new DataTransfer();
        colorImages[colorId].forEach(file => dt.items.add(file));
        input.files = dt.files;
        handleColorImagesChange({ target: input });
    };
    
    // Size Selection
    document.querySelectorAll('.size-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const sizeId = this.value;
            const sizeName = this.dataset.sizeName;
            
            if (this.checked) {
                selectedSizes.push({ id: sizeId, name: sizeName });
            } else {
                const index = selectedSizes.findIndex(s => s.id == sizeId);
                if (index > -1) selectedSizes.splice(index, 1);
            }
            
            generateVariantsTable();
        });
    });
    
    // Generate Variants Table
    function generateVariantsTable() {
        const sizeHeaders = document.getElementById('sizeHeaders');
        const tableBody = document.getElementById('variantsTableBody');
        
        if (selectedColors.length === 0 || selectedSizes.length === 0) {
            sizeHeaders.innerHTML = '<span class="text-muted">Chọn màu sắc và kích cỡ để tạo bảng</span>';
            tableBody.innerHTML = `
                <tr>
                    <td colspan="100" class="text-center text-muted py-4">
                        Vui lòng chọn màu sắc và kích cỡ ở trên
                    </td>
                </tr>
            `;
            return;
        }
        
        // Generate size headers
        const headerRow = sizeHeaders.parentNode;
        
        // Remove all dynamically added th elements (those after sizeHeaders)
        let nextTh = sizeHeaders.nextElementSibling;
        while (nextTh) {
            const toRemove = nextTh;
            nextTh = nextTh.nextElementSibling;
            toRemove.remove();
        }
        
        // Use sizeHeaders for the first size, remove colspan
        sizeHeaders.innerHTML = selectedSizes[0].name;
        sizeHeaders.colSpan = 1;
        sizeHeaders.className = 'text-center';
        sizeHeaders.style.minWidth = '150px';
        
        // Add remaining size headers
        for (let i = 1; i < selectedSizes.length; i++) {
            const th = document.createElement('th');
            th.className = 'text-center';
            th.textContent = selectedSizes[i].name;
            th.style.minWidth = '150px';
            headerRow.appendChild(th);
        }
        
        // Generate rows for each color
        tableBody.innerHTML = '';
        selectedColors.forEach(color => {
            const row = document.createElement('tr');
            
            // Color cell with image preview
            const colorCell = document.createElement('td');
            colorCell.className = 'align-middle';
            const images = colorImages[color.id] || [];
            const imagePreview = images.length > 0 ? 
                `<img src="${URL.createObjectURL(images[0])}" class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">` : '';
            colorCell.innerHTML = `
                ${imagePreview}
                <span class="badge" style="background-color: ${color.color};">&nbsp;&nbsp;</span>
                <strong>${color.name}</strong>
            `;
            row.appendChild(colorCell);
            
            // Size cells with input fields
            selectedSizes.forEach(size => {
                const sizeCell = document.createElement('td');
                sizeCell.innerHTML = `
                    <div class="mb-2">
                        <label class="form-label small">Giá (VNĐ)</label>
                        <input type="number" class="form-control form-control-sm variant-price" 
                               name="variants[${color.id}_${size.id}][gia]" 
                               data-color="${color.id}" data-size="${size.id}" 
                               min="0" step="1000" required>
                        <input type="hidden" name="variants[${color.id}_${size.id}][mausacid]" value="${color.id}">
                        <input type="hidden" name="variants[${color.id}_${size.id}][kichcoid]" value="${size.id}">
                    </div>
                    <div>
                        <label class="form-label small">Số lượng</label>
                        <input type="number" class="form-control form-control-sm variant-quantity" 
                               name="variants[${color.id}_${size.id}][soluong]" 
                               min="0" required>
                    </div>
                `;
                row.appendChild(sizeCell);
            });
            
            tableBody.appendChild(row);
        });
    }
    
    // Form submission handling
    document.getElementById('productForm').addEventListener('submit', function(e) {
        if (selectedColors.length === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất một màu sắc!');
            return false;
        }
        
        if (selectedSizes.length === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất một kích cỡ!');
            return false;
        }
        
        // Validate that all colors have images
        for (let color of selectedColors) {
            if (!colorImages[color.id] || colorImages[color.id].length === 0) {
                e.preventDefault();
                alert(`Vui lòng thêm hình ảnh cho màu: ${color.name}`);
                return false;
            }
        }
        
        // Prepare form data for color images
        const formData = new FormData(this);
        
        // Add color images to form data
        selectedColors.forEach(color => {
            formData.append(`colors[${color.id}][id]`, color.id);
            if (colorImages[color.id]) {
                colorImages[color.id].forEach((file, index) => {
                    formData.append(`colors[${color.id}][images][]`, file);
                });
            }
        });
        
        // Show loading animation
        showButtonLoading('submitBtn');
        
        // Remove old form and submit with FormData
        e.preventDefault();
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            } else {
                return response.json();
            }
        })
        .catch(error => {
            hideButtonLoading('submitBtn');
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi lưu sản phẩm!');
        });
    });
});
</script>
@endpush
