@extends('layouts.app')

@section('title', 'LK fashion - Thời trang nữ hiện đại')

@section('content')
<section class="hero-banner">
    <div class="container hero-layout">
        <div class="hero-content">
            <span class="eyebrow">Bộ sưu tập đồ nữ mới 2026</span>
            <h1 class="hero-title">Phong cách nữ tính, tự tin mỗi ngày.</h1>
            <p class="hero-subtitle">Từ áo thun, áo khoác, váy, quần jeans đến phụ kiện, mọi item đều được thiết kế riêng cho phái đẹp hiện đại.</p>
            <div class="hero-actions">
                <a href="#" class="btn-primary">Khám phá ngay</a>
                <a href="#" class="btn-secondary">Xem ưu đãi</a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <strong>10k+</strong>
                    <span>Khách hàng tin tưởng</span>
                </div>
                <div class="hero-stat">
                    <strong>24/7</strong>
                    <span>Hỗ trợ giao hàng</span>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-card large">
                <img src="https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=900&q=80" alt="Mẫu thời trang nữ hiện đại">
            </div>
            <div class="hero-card small">
                <img src="https://images.unsplash.com/photo-1487412912498-0447578fcca8?auto=format&fit=crop&w=700&q=80" alt="Bộ sưu tập đồ nữ">
            </div>
        </div>
    </div>
</section>

<section class="product-section">
    <div class="container">
        <div class="section-intro">
            <div>
                <p class="eyebrow eyebrow-dark">Bộ sưu tập nổi bật</p>
                <h2>Trang phục nữ cho mọi hoạt động</h2>
            </div>
            <a href="#" class="view-all">Xem tất cả <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="collection-grid">
            <article class="collection-card">
                <img src="https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=800&q=80" alt="Bộ sưu tập casual nữ">
                <h3>Casual Everyday</h3>
                <p>Những item nhẹ nhàng, dễ phối và phù hợp cho cả đi làm lẫn dạo phố.</p>
            </article>
            <article class="collection-card">
                <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=800&q=80" alt="Bộ sưu tập streetwear nữ">
                <h3>Streetwear Cool</h3>
                <p>Phong cách mạnh mẽ, năng động cùng các tone màu nổi bật và chất liệu bền đẹp.</p>
            </article>
            <article class="collection-card">
                <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=800&q=80" alt="Bộ sưu tập premium nữ">
                <h3>Premium Minimal</h3>
                <p>Thiết kế tối giản, tinh tế và sang trọng cho các buổi gặp gỡ quan trọng.</p>
            </article>
        </div>
    </div>
</section>

<section class="product-section">
    <div class="container">
        <div class="section-header">
            <h2>Sản phẩm bán chạy</h2>
            <a href="#" class="view-all">Xem tất cả <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="product-grid grid-4">
            @forelse($featuredProducts as $product)
            <div class="product-card" data-product-id="{{ $product->id }}">
                <div class="product-image">
                    @php
                        $firstImage = $product->images->first();
                    @endphp
                    <img src="{{ $firstImage ? $firstImage->hinhanh : $product->hinhanh }}" 
                         alt="{{ $product->ten }}"
                         class="product-main-image">
                    @if($product->giagiam)
                        <div class="product-badge">Sale</div>
                    @endif
                </div>
                <div class="product-info">
                    <h3 class="product-name">{{ $product->ten }}</h3>
                    
                    @php
                        $availableColors = $product->images->unique('mausacid')->pluck('mauSac')->filter();
                    @endphp
                    
                    @if($availableColors->count() > 0)
                    <div class="product-colors" style="display: flex; gap: 8px; margin: 8px 0;">
                        @foreach($availableColors as $color)
                        <button class="color-selector" 
                                data-product-id="{{ $product->id }}"
                                data-color-id="{{ $color->id }}"
                                style="width: 24px; height: 24px; border-radius: 50%; border: 2px solid #ddd; background-color: {{ $color->ma_mau }}; cursor: pointer;"
                                title="{{ $color->ten }}">
                        </button>
                        @endforeach
                    </div>
                    @endif
                    
                    <div class="product-price">
                        @if($product->giagiam)
                            <span class="price">{{ number_format($product->giagiam, 0, ',', '.') }}đ</span>
                            <span class="old-price">{{ number_format($product->giaban, 0, ',', '.') }}đ</span>
                        @else
                            <span class="price">{{ number_format($product->giaban, 0, ',', '.') }}đ</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p>Chưa có sản phẩm nào.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="feature-band">
    <div class="container feature-grid">
        <div class="feature-card">
            <i class="fas fa-truck-fast"></i>
            <h3>Giao hàng nhanh</h3>
            <p>Đảm bảo đơn hàng đến tay bạn trong vòng 24 giờ tại nội thành.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-shield-alt"></i>
            <h3>Đổi trả dễ dàng</h3>
            <p>Chính sách đổi trả linh hoạt trong 7 ngày nếu sản phẩm không đúng yêu cầu.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-tags"></i>
            <h3>Khuyến mãi hấp dẫn</h3>
            <p>Ưu đãi mỗi tuần và voucher cho khách hàng mới đăng ký.</p>
        </div>
    </div>
</section>

<section class="product-section">
    <div class="container">
        <div class="section-header">
            <h2>Sản phẩm mới về</h2>
            <a href="#" class="view-all">Xem tất cả <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="product-grid grid-4">
            @forelse($newProducts as $product)
            <div class="product-card" data-product-id="{{ $product->id }}">
                <div class="product-image">
                    @php
                        $firstImage = $product->images->first();
                    @endphp
                    <img src="{{ $firstImage ? $firstImage->hinhanh : $product->hinhanh }}" 
                         alt="{{ $product->ten }}"
                         class="product-main-image">
                    <div class="product-badge">New</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">{{ $product->ten }}</h3>
                    
                    @php
                        $availableColors = $product->images->unique('mausacid')->pluck('mauSac')->filter();
                    @endphp
                    
                    @if($availableColors->count() > 0)
                    <div class="product-colors" style="display: flex; gap: 8px; margin: 8px 0;">
                        @foreach($availableColors as $color)
                        <button class="color-selector" 
                                data-product-id="{{ $product->id }}"
                                data-color-id="{{ $color->id }}"
                                style="width: 24px; height: 24px; border-radius: 50%; border: 2px solid #ddd; background-color: {{ $color->ma_mau }}; cursor: pointer;"
                                title="{{ $color->ten }}">
                        </button>
                        @endforeach
                    </div>
                    @endif
                    
                    <div class="product-price">
                        @if($product->giagiam)
                            <span class="price">{{ number_format($product->giagiam, 0, ',', '.') }}đ</span>
                            <span class="old-price">{{ number_format($product->giaban, 0, ',', '.') }}đ</span>
                        @else
                            <span class="price">{{ number_format($product->giaban, 0, ',', '.') }}đ</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p>Chưa có sản phẩm mới nào.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="product-section">
    <div class="container story-grid">
        <div class="story-card story-main">
            <p class="eyebrow eyebrow-dark">Về LK fashion</p>
            <h3>Thời trang nữ chất lượng, giá trị bền vững</h3>
            <p>Chúng tôi mang đến những sản phẩm được thiết kế để bạn luôn thoải mái, tự tin và phù hợp với nhịp sống hiện đại.</p>
            <a href="#" class="btn-primary">Tìm hiểu thêm</a>
        </div>
        <div class="story-card story-list">
            <div>
                <h4>Chất liệu cao cấp</h4>
                <p>Vải bền, mềm mại và thoáng mát trong mọi thời tiết.</p>
            </div>
            <div>
                <h4>Thiết kế đa dạng</h4>
                <p>Phù hợp cho công sở, dạo phố, du lịch và các dịp đặc biệt.</p>
            </div>
            <div>
                <h4>Hỗ trợ tận tâm</h4>
                <p>Đội ngũ tư vấn luôn sẵn sàng giúp bạn chọn outfit phù hợp.</p>
            </div>
        </div>
    </div>
</section>

<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <h2>Nhận tin khuyến mãi mới nhất từ chúng tôi</h2>
            <p>Đăng ký ngay để không bỏ lỡ các ưu đãi hấp dẫn.</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Nhập email của bạn" required>
                <button type="submit" class="btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prepare product images data
    const productImagesData = {
        @foreach($featuredProducts as $product)
        {{ $product->id }}: {
            @foreach($product->images->groupBy('mausacid') as $colorId => $images)
            {{ $colorId }}: {!! json_encode($images->pluck('hinhanh')->toArray()) !!},
            @endforeach
        },
        @endforeach
        @foreach($newProducts as $product)
        {{ $product->id }}: {
            @foreach($product->images->groupBy('mausacid') as $colorId => $images)
            {{ $colorId }}: {!! json_encode($images->pluck('hinhanh')->toArray()) !!},
            @endforeach
        },
        @endforeach
    };

    // Add click handlers to all color selector buttons
    document.querySelectorAll('.color-selector').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.getAttribute('data-product-id');
            const colorId = this.getAttribute('data-color-id');
            
            // Find the product card
            const productCard = document.querySelector(`.product-card[data-product-id="${productId}"]`);
            if (!productCard) return;
            
            // Remove active state from all color buttons in this product
            productCard.querySelectorAll('.color-selector').forEach(function(btn) {
                btn.style.border = '2px solid #ddd';
                btn.style.transform = 'scale(1)';
            });
            
            // Add active state to clicked button
            this.style.border = '3px solid #333';
            this.style.transform = 'scale(1.1)';
            
            // Get images for this product and color
            if (productImagesData[productId] && productImagesData[productId][colorId]) {
                const images = productImagesData[productId][colorId];
                
                // Update the main product image
                const mainImage = productCard.querySelector('.product-main-image');
                if (mainImage && images.length > 0) {
                    mainImage.src = images[0];
                }
            }
        });
    });
    
    // Set initial active state for first color button of each product
    document.querySelectorAll('.product-card').forEach(function(card) {
        const firstColorButton = card.querySelector('.color-selector');
        if (firstColorButton) {
            firstColorButton.style.border = '3px solid #333';
            firstColorButton.style.transform = 'scale(1.1)';
        }
    });
});
</script>

<style>
.color-selector {
    transition: all 0.2s ease;
}

.color-selector:hover {
    transform: scale(1.15) !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.product-main-image {
    transition: opacity 0.3s ease;
}
</style>
@endsection
