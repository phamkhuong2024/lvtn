<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LK fashion - Thời trang chất lượng')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                      
                    </ul>
                </nav>
                <div class="header-actions" style="display:flex; align-items:center; gap:12px;">
                    <form action="{{ route('products') }}" method="GET" class="header-search-form" style="display:flex; align-items:center; gap:8px;">
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm sản phẩm" style="padding:8px 12px; border-radius:999px; border:1px solid #ddd; min-width:200px; outline:none;">
                        <button type="submit" class="icon-link" style="border:none; background:none; padding:0; cursor:pointer; color:#333;"><i class="fas fa-search"></i></button>
                    </form>
                    
                    @if(Auth::guard('admin')->check())
                        <div class="user-dropdown">
                            <a href="#" class="icon-link user-link">
                                <i class="fas fa-user"></i>
                                <span>{{ Auth::guard('admin')->user()->tenad }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="{{ route('admin.profile') }}">Hồ sơ</a>
                                <a href="{{ route('logout') }}">Đăng xuất</a>
                            </div>
                        </div>
                    @elseif(Auth::guard('nhanvien')->check())
                        <div class="user-dropdown">
                            <a href="#" class="icon-link user-link">
                                <i class="fas fa-user"></i>
                                <span>{{ Auth::guard('nhanvien')->user()->tennv }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="{{ route('nhanvien.profile') }}">Hồ sơ</a>
                                <a href="{{ route('logout') }}">Đăng xuất</a>
                            </div>
                        </div>
                    @elseif(Auth::guard('khachhang')->check())
                        <div class="user-dropdown">
                            <a href="#" class="icon-link user-link">
                                <i class="fas fa-user"></i>
                                <span>{{ Auth::guard('khachhang')->user()->ten }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="{{ route('khachhang.order.index') }}">Đơn hàng</a>
                                <a href="{{ route('khachhang.profile') }}">Hồ sơ</a>
                                <a href="{{ route('logout') }}">Đăng xuất</a>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="icon-link"><i class="fas fa-user"></i></a>
                    @endif
                    @php
                        $cartCount = collect(session('cart', []))->sum('quantity');
                    @endphp
                    <a href="{{ route('cart.index') }}" class="icon-link cart-link" style="position: relative;">
                        <i class="fas fa-shopping-cart"></i>
                        @if($cartCount > 0)
                            <span class="cart-count-badge" style="position: absolute; top: -6px; right: -6px; display: inline-flex; align-items: center; justify-content: center; width: 20px; height: 20px; border-radius: 50%; background: #dc3545; color: #fff; font-size: 12px; font-weight: 700;">{{ $cartCount }}</span>
                        @endif
                    </a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
