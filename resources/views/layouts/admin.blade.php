<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-body">
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="admin-brand">LK Fashion</div>
            <nav class="admin-nav">
                @if(Auth::guard('nhanvien')->check())
                    {{-- Nhân viên chỉ xem được Đơn hàng --}}
                    <a href="#"><i class="fas fa-shopping-cart"></i> Đơn hàng</a>
                    <a href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Về cửa hàng</a>
                @else
                    {{-- Admin xem được tất cả --}}
                    <a href="{{ route('admin.dashboard') }}" class="active"><i class="fas fa-home"></i> Tổng quan</a>
                    <a href="{{ route('category.index') }}"><i class="fas fa-list"></i> Danh mục</a>
                    
                    <a href="{{ route('producttype.index') }}"><i class="fas fa-tags"></i> Loại sản phẩm</a>
                    <!-- Sản phẩm Accordion -->
                    <button type="button" data-bs-toggle="collapse" data-bs-target="#productSubmenu" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-box"></i> Sản phẩm
                    </button>
                    <div class="collapse" id="productSubmenu">
                        <a href="{{ route('product.index') }}" class="submenu-item"><i class="fas fa-box-open"></i> Sản phẩm</a>
                        <a href="{{ route('color.index') }}" class="submenu-item"><i class="fas fa-palette"></i> Màu sắc</a>
                        <a href="{{ route('size.index') }}" class="submenu-item"><i class="fas fa-ruler"></i> Kích cỡ</a>
                    </div>
                    
                    <a href="#"><i class="fas fa-shopping-cart"></i> Đơn hàng</a>
                    <a href="{{ route('khachhang.index') }}"><i class="fas fa-users"></i> Khách hàng</a>
                    <a href="{{ route('nhanvien.index') }}"><i class="fas fa-user-tie"></i> Nhân viên</a>
                    <a href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Về cửa hàng</a>
                @endif
            </nav>
        </aside>
        <div class="d-flex flex-column h-md-100 justify-content-between w-100">
            <header class="admin-topbar mx-4">
                <div>
                    <p class="muted">Xin chào, {{ Auth::guard('nhanvien')->check() ? 'Nhân viên' : 'Admin' }}</p>
                    <h2>{{ Auth::guard('nhanvien')->check() ? 'Quản lý đơn hàng' : 'Dashboard quản trị' }}</h2>
                </div>
                <div class="admin-user">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ Auth::guard('nhanvien')->check() ? Auth::guard('nhanvien')->user()->ten_nhan_vien : 'Admin LK Fashion' }}</span>
                </div>
            </header>
            <main class="admin-main">
            @yield('content')
            </main>
        </div>
    </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
