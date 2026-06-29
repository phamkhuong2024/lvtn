@extends('layouts.app')

@section('title', $product->ten . ' - LK fashion')

@section('content')
<div class="product-detail-container">
    <div class="container">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span>/</span>
            <a href="#">{{ $product->category->ten }}</a>
            <span>/</span>
            <span>{{ $product->ten }}</span>
        </nav>

        <div class="product-detail-layout">
            <!-- Product Images -->
            <div class="product-gallery">
                <div class="main-image-container">
                    @php
                        $firstImage = $product->images->first();
                    @endphp
                    <img id="mainImage" 
                         src="{{ $firstImage ? $firstImage->hinhanh : $product->hinhanh }}" 
                         alt="{{ $product->ten }}"
                         class="main-product-image">
                </div>
                
                <div class="thumbnail-container" id="thumbnailContainer">
                    @if($product->images->count() > 0)
                        @foreach($product->images->take(6) as $index => $image)
                        <img src="{{ $image->hinhanh }}" 
                             alt="{{ $product->ten }}"
                             class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                             data-color-id="{{ $image->mausacid }}"
                             onclick="changeMainImage('{{ $image->hinhanh }}', this)">
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Product Information -->
            <div class="product-info-section">
                <h1 class="product-title">{{ $product->ten }}</h1>
                
                <div class="product-meta">
                    <span class="product-category">{{ $product->category->ten }}</span>
                    @if($product->type)
                        <span class="product-type">{{ $product->type->ten }}</span>
                    @endif
                </div>

                <div class="product-price-section">
                    @if($product->giagiam)
                        <span class="current-price">{{ number_format($product->giagiam, 0, ',', '.') }}đ</span>
                        <span class="original-price">{{ number_format($product->giaban, 0, ',', '.') }}đ</span>
                        <span class="discount-badge">-{{ round((($product->giaban - $product->giagiam) / $product->giaban) * 100) }}%</span>
                    @else
                        <span class="current-price">{{ number_format($product->giaban, 0, ',', '.') }}đ</span>
                    @endif
                </div>

                @if($product->mota)
                <div class="product-short-description">
                    <p>{{ Str::limit($product->mota, 200) }}</p>
                </div>
                @endif

                <!-- Color Selection -->
                @if($colors->count() > 0)
                <div class="selection-group">
                    <label class="selection-label">Màu sắc:</label>
                    <div class="color-options" id="colorOptions">
                        @foreach($colors as $index => $color)
                        <button class="color-option {{ $index === 0 ? 'active' : '' }}" 
                                data-color-id="{{ $color->id }}"
                                data-color-name="{{ $color->ten }}"
                                onclick="selectColor({{ $color->id }}, '{{ $color->ten }}')">
                            <span class="color-circle" style="background-color: {{ $color->ma_mau }}"></span>
                            <span class="color-name">{{ $color->ten }}</span>
                        </button>
                        @endforeach
                    </div>
                    <input type="hidden" id="selectedColor" value="{{ $colors->first()->id ?? '' }}">
                </div>
                @endif

                <!-- Size Selection -->
                @if($sizes->count() > 0)
                <div class="selection-group">
                    <label class="selection-label">Kích cỡ:</label>
                    <div class="size-options" id="sizeOptions">
                        @foreach($sizes as $index => $size)
                        <button class="size-option {{ $index === 0 ? 'active' : '' }}" 
                                data-size-id="{{ $size->id }}"
                                onclick="selectSize({{ $size->id }}, '{{ $size->ten }}')">
                            {{ $size->ten }}
                        </button>
                        @endforeach
                    </div>
                    <input type="hidden" id="selectedSize" value="{{ $sizes->first()->id ?? '' }}">
                </div>
                @endif

                <!-- Quantity Selection -->
                <div class="selection-group">
                    <label class="selection-label">Số lượng:</label>
                    <div class="quantity-selector">
                        <button type="button" class="qty-btn" onclick="decreaseQuantity()">-</button>
                        <input type="number" id="quantity" value="1" min="1" max="99" readonly>
                        <button type="button" class="qty-btn" onclick="increaseQuantity()">+</button>
                    </div>
                    <span class="stock-info" id="stockInfo">Còn hàng</span>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="button" class="btn-add-cart" onclick="addToCart()">
                        <i class="fas fa-shopping-cart"></i>
                        Thêm vào giỏ hàng
                    </button>
                    <button type="button" class="btn-buy-now" onclick="buyNow()">
                        Mua ngay
                    </button>
                </div>

                <!-- Additional Info -->
                <div class="product-features">
                    <div class="feature-item">
                        <i class="fas fa-truck"></i>
                        <span>Giao hàng nhanh 24h</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-undo"></i>
                        <span>Đổi trả trong 7 ngày</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Cam kết chính hãng</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        @if($product->mota)
        <div class="product-description-section">
            <h2>Mô tả sản phẩm</h2>
            <div class="description-content">
                <p>{{ $product->mota }}</p>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Product images data grouped by color
const productImagesByColor = {
    @foreach($imagesByColor as $colorId => $images)
    {{ $colorId }}: {!! json_encode($images->pluck('hinhanh')->toArray()) !!},
    @endforeach
};

// Product variants data
const productVariants = {!! json_encode($product->variants->map(function($variant) {
    return [
        'mausacid' => $variant->mausacid,
        'kichcoid' => $variant->kichcoid,
        'soluong' => $variant->soluong,
        'gia' => $variant->gia,
    ];
})) !!};

let selectedColorId = {{ $colors->first()->id ?? 'null' }};
let selectedSizeId = {{ $sizes->first()->id ?? 'null' }};

function changeMainImage(imageSrc, thumbnailElement) {
    document.getElementById('mainImage').src = imageSrc;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.classList.remove('active');
    });
    thumbnailElement.classList.add('active');
}

function selectColor(colorId, colorName) {
    selectedColorId = colorId;
    document.getElementById('selectedColor').value = colorId;
    
    // Update active color button
    document.querySelectorAll('.color-option').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.closest('.color-option').classList.add('active');
    
    // Update images for selected color
    updateImagesForColor(colorId);
    
    // Check stock availability
    checkStock();
}

function updateImagesForColor(colorId) {
    const images = productImagesByColor[colorId];
    const thumbnailContainer = document.getElementById('thumbnailContainer');
    
    if (images && images.length > 0) {
        // Update main image
        document.getElementById('mainImage').src = images[0];
        
        // Update thumbnails
        thumbnailContainer.innerHTML = '';
        images.forEach((imageSrc, index) => {
            const img = document.createElement('img');
            img.src = imageSrc;
            img.alt = '{{ $product->ten }}';
            img.className = 'thumbnail' + (index === 0 ? ' active' : '');
            img.setAttribute('data-color-id', colorId);
            img.onclick = function() { changeMainImage(imageSrc, this); };
            thumbnailContainer.appendChild(img);
        });
    }
}

function selectSize(sizeId, sizeName) {
    selectedSizeId = sizeId;
    document.getElementById('selectedSize').value = sizeId;
    
    // Update active size button
    document.querySelectorAll('.size-option').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Check stock availability
    checkStock();
}

function checkStock() {
    const variant = productVariants.find(v => 
        v.mausacid == selectedColorId && v.kichcoid == selectedSizeId
    );
    
    const stockInfo = document.getElementById('stockInfo');
    if (variant) {
        if (variant.soluong > 0) {
            stockInfo.textContent = `Còn ${variant.soluong} sản phẩm`;
            stockInfo.style.color = '#28a745';
        } else {
            stockInfo.textContent = 'Hết hàng';
            stockInfo.style.color = '#dc3545';
        }
    } else {
        stockInfo.textContent = 'Không có sẵn';
        stockInfo.style.color = '#dc3545';
    }
}

function increaseQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue < 99) {
        input.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function addToCart() {
    const quantity = document.getElementById('quantity').value;
    const colorId = document.getElementById('selectedColor').value;
    const sizeId = document.getElementById('selectedSize').value;
    
    // Check if variant is available
    const variant = productVariants.find(v => 
        v.mausacid == colorId && v.kichcoid == sizeId
    );
    
    if (!variant || variant.soluong <= 0) {
        alert('Sản phẩm này hiện không có sẵn!');
        return;
    }
    
    if (parseInt(quantity) > variant.soluong) {
        alert('Số lượng vượt quá hàng có sẵn!');
        return;
    }
    
    // TODO: Implement add to cart functionality
    console.log('Add to cart:', {
        productId: {{ $product->id }},
        colorId: colorId,
        sizeId: sizeId,
        quantity: quantity
    });
    
    alert('Đã thêm vào giỏ hàng!');
}

function buyNow() {
    addToCart();
    // TODO: Redirect to checkout
    // window.location.href = '/checkout';
}

// Initialize stock check on page load
document.addEventListener('DOMContentLoaded', function() {
    checkStock();
});
</script>

<style>
.product-detail-container {
    padding: 40px 0;
    background: #f8f9fa;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 30px;
    font-size: 14px;
}

.breadcrumb a {
    color: #666;
    text-decoration: none;
}

.breadcrumb a:hover {
    color: #333;
}

.breadcrumb span:last-child {
    color: #333;
    font-weight: 500;
}

.product-detail-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.product-gallery {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.main-image-container {
    width: 100%;
    aspect-ratio: 1;
    overflow: hidden;
    border-radius: 8px;
    background: #f5f5f5;
}

.main-product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.main-product-image:hover {
    transform: scale(1.05);
}

.thumbnail-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 12px;
}

.thumbnail {
    width: 100%;
    aspect-ratio: 1;
    object-fit: cover;
    border-radius: 6px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s ease;
}

.thumbnail:hover {
    border-color: #ddd;
}

.thumbnail.active {
    border-color: #333;
}

.product-info-section {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.product-title {
    font-size: 28px;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.product-meta {
    display: flex;
    gap: 12px;
    font-size: 14px;
}

.product-category,
.product-type {
    padding: 4px 12px;
    background: #f0f0f0;
    border-radius: 4px;
    color: #666;
}

.product-price-section {
    display: flex;
    align-items: center;
    gap: 12px;
}

.current-price {
    font-size: 32px;
    font-weight: 700;
    color: #d32f2f;
}

.original-price {
    font-size: 20px;
    color: #999;
    text-decoration: line-through;
}

.discount-badge {
    padding: 4px 8px;
    background: #d32f2f;
    color: white;
    border-radius: 4px;
    font-size: 14px;
    font-weight: 600;
}

.product-short-description {
    color: #666;
    line-height: 1.6;
}

.selection-group {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.selection-label {
    font-weight: 600;
    color: #333;
    font-size: 16px;
}

.color-options,
.size-options {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.color-option {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 2px solid #ddd;
    border-radius: 6px;
    background: white;
    cursor: pointer;
    transition: all 0.2s ease;
}

.color-option:hover {
    border-color: #999;
}

.color-option.active {
    border-color: #333;
    background: #f5f5f5;
}

.color-circle {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 1px solid #ddd;
}

.color-name {
    font-size: 14px;
    color: #333;
}

.size-option {
    min-width: 60px;
    padding: 10px 20px;
    border: 2px solid #ddd;
    border-radius: 6px;
    background: white;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s ease;
}

.size-option:hover {
    border-color: #999;
}

.size-option.active {
    border-color: #333;
    background: #333;
    color: white;
}

.quantity-selector {
    display: flex;
    align-items: center;
    gap: 12px;
    width: fit-content;
}

.qty-btn {
    width: 36px;
    height: 36px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: white;
    cursor: pointer;
    font-size: 18px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.qty-btn:hover {
    background: #f5f5f5;
}

#quantity {
    width: 60px;
    height: 36px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    font-weight: 500;
}

.stock-info {
    font-size: 14px;
    font-weight: 500;
    margin-left: 12px;
}

.action-buttons {
    display: flex;
    gap: 12px;
    margin-top: 12px;
}

.btn-add-cart,
.btn-buy-now {
    flex: 1;
    padding: 14px 24px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-add-cart {
    background: white;
    color: #333;
    border: 2px solid #333;
}

.btn-add-cart:hover {
    background: #333;
    color: white;
}

.btn-buy-now {
    background: #333;
    color: white;
}

.btn-buy-now:hover {
    background: #555;
}

.product-features {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 6px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    color: #666;
}

.feature-item i {
    color: #28a745;
    font-size: 18px;
}

.product-description-section {
    margin-top: 40px;
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.product-description-section h2 {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
}

.description-content {
    color: #666;
    line-height: 1.8;
}

@media (max-width: 768px) {
    .product-detail-layout {
        grid-template-columns: 1fr;
        gap: 30px;
        padding: 20px;
    }
    
    .product-title {
        font-size: 22px;
    }
    
    .current-price {
        font-size: 24px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
@endsection
