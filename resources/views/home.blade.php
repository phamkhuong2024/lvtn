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
            <div class="product-card">
                <div class="product-image">
                        <img src="https://buggy.yodycdn.com/images/product/916b6e0be53be04f51a79fe352304829.webp?width=987&height=1316" alt="Áo khoác nữ">
                    <div class="product-badge">Hot</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Áo Khoác Nữ</h3>
                    <div class="product-price">
                        <span class="price">890.000đ</span>
                        <span class="old-price">1.090.000đ</span>
                    </div>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">
                    <img src="https://buggy.yodycdn.com/images/product/ea5e1a54458883b9b77497ee21ff922b.webp?width=987&height=1316" alt="Áo thun nữ">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Áo Thun Nữ</h3>
                    <div class="product-price">
                        <span class="price">290.000đ</span>
                    </div>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">
                    <img src="https://buggy.yodycdn.com/images/product/3322c6398f4b9c5abdcf729c5d881643.webp?width=987&height=1316" alt="Quần jeans nữ">
                    <div class="product-badge">New</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Quần Jeans Nữ</h3>
                    <div class="product-price">
                        <span class="price">590.000đ</span>
                    </div>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">
                    <img src="https://buggy.yodycdn.com/images/product/5aeb0529419af08853475b4417e2e525.webp?width=987&height=1316" alt="Áo sơ mi nữ">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Áo Sơ Mi Nữ</h3>
                    <div class="product-price">
                        <span class="price">390.000đ</span>
                    </div>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">
                    <img src="https://buggy.yodycdn.com/images/product/5aeb0529419af08853475b4417e2e525.webp?width=987&height=1316" alt="Váy maxi nữ">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Váy Maxi Nữ</h3>
                    <div class="product-price">
                        <span class="price">650.000đ</span>
                    </div>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">
                    <img src="https://buggy.yodycdn.com/images/product/b6452c8944dcaae4df2e3533d468c765.webp?width=987&height=1316" alt="Túi xách nữ">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Túi Xách Nữ</h3>
                    <div class="product-price">
                        <span class="price">480.000đ</span>
                    </div>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">
                    <img src="https://buggy.yodycdn.com/images/product/418b73800777e421d09ac5dc8031ca73.webp?width=987&height=1316" alt="Giày Nữ Cao Cấp">
                    <div class="product-badge">Sale</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Giày Nữ Cao Cấp</h3>
                    <div class="product-price">
                        <span class="price">550.000đ</span>
                    </div>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">
                    <img src="https://buggy.yodycdn.com/images/product/af5971d26454507631eeaf581a3147a3.webp?width=987&height=1316" alt="Áo Nỉ Có Mũ Nữ">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Áo Nỉ Có Mũ</h3>
                    <div class="product-price">
                        <span class="price">520.000đ</span>
                    </div>
                </div>
            </div>
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
            <div class="product-card">
                <div class="product-image">
                    <img src="https://buggy.yodycdn.com/images/product/8cdf0d0e6299efc71280bf50d17c30f6.webp?width=987&height=1316" alt="Áo thun nữ thể thao chống nắng">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Áo Thun Nữ Thể Thao Chống Nắng</h3>
                    <div class="product-price">
                        <span class="price">350.000đ</span>
                    </div>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">
                    <img src="https://buggy.yodycdn.com/images/product/af5971d26454507631eeaf581a3147a3.webp?width=987&height=1316" alt="Áo Nỉ Có Mũ">
                    <div class="product-badge">New</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Áo Nỉ Có Mũ</h3>
                    <div class="product-price">
                        <span class="price">480.000đ</span>
                    </div>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">
                    <img src="https://buggy.yodycdn.com/images/product/d62291e883082b8289d6e9741a449190.webp?width=987&height=1316" alt="Quần Kaki Nữ Straight Soft Cạp Chéo">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Quần Kaki Nữ Straight Soft Cạp Chéo</h3>
                    <div class="product-price">
                        <span class="price">599.000đ</span>
                    </div>
                </div>
            </div>
            <div class="product-card">
                <div class="product-image">
                    <img src="https://buggy.yodycdn.com/images/product/418b73800777e421d09ac5dc8031ca73.webp?width=987&height=1316" alt="Giày Nữ Cao Cấp">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Giày Nữ Cao Cấp</h3>
                    <div class="product-price">
                        <span class="price">550.000đ</span>
                    </div>
                </div>
            </div>
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
@endsection
