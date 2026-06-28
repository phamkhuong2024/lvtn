<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LK fashion - Thời trang chất lượng')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-top">
                <div class="logo">
                    <a href="/">LK fashion</a>
                </div>
                <nav class="main-nav">
                    <ul>
                        <li><a href="/" class="active">TRANG CHỦ</a></li>
                        <li><a href="{{ route('products') }}">SẢN PHẨM</a></li>
                        <li><a href="/about">GIỚI THIỆU</a></li>
                        <li><a href="/contact">LIÊN HỆ</a></li>
                    </ul>
                </nav>
                <div class="header-actions">
                    <a href="#" class="icon-link"><i class="fas fa-search"></i></a>
                    <a href="{{ route('login') }}" class="icon-link"><i class="fas fa-user"></i></a>
                    <a href="#" class="icon-link"><i class="fas fa-shopping-cart"></i></a>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>LK fashion</h3>
                    <p>Thời trang chất lượng cao, phong cách hiện đại</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Hỗ trợ</h4>
                    <ul>
                        <li><a href="#">Hướng dẫn mua hàng</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Điều khoản sử dụng</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Về chúng tôi</h4>
                    <ul>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="#">Tuyển dụng</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Liên hệ</h4>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Địa chỉ: 123 Đường ABC, TP.HCM</li>
                        <li><i class="fas fa-phone"></i> Hotline: 1900 xxxx</li>
                        <li><i class="fas fa-envelope"></i> Email: info@lkfashion.vn</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 LK fashion. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <button id="scrollTopBtn" class="scroll-top-btn" aria-label="Quay về đầu trang">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
