@extends('layouts.admin')

@section('content')
            <section class="admin-stats">
                <div class="stat-card">
                    <h3>Doanh thu hôm nay</h3>
                    <div class="value">{{ number_format($revenueToday, 0, ',', '.') }}₫</div>
                    <div class="sub">Doanh thu từ đơn hàng hôm nay</div>
                </div>
                <div class="stat-card">
                    <h3>Doanh thu tháng {{ now()->format('m/Y') }}</h3>
                    <div class="value">{{ number_format($monthlyRevenue, 0, ',', '.') }}₫</div>
                    <div class="sub">{{ $monthlyOrders }} đơn hàng</div>
                </div>
                <div class="stat-card">
                    <h3>Doanh thu quý {{ $currentQuarter }}</h3>
                    <div class="value">{{ number_format($quarterRevenue, 0, ',', '.') }}₫</div>
                    <div class="sub">{{ $quarterOrders }} đơn hàng</div>
                </div>
                <div class="stat-card">
                    <h3>Doanh thu năm {{ $currentYear }}</h3>
                    <div class="value">{{ number_format($yearlyRevenue, 0, ',', '.') }}₫</div>
                    <div class="sub">{{ $yearlyOrders }} đơn hàng</div>
                </div>
            </section>

            <section class="admin-products-section" id="product-section">
                <div class="admin-panel">
                    <div class="panel-heading">
                        <h3>Danh sách sản phẩm mới</h3>
                        <a href="{{ route('product.create') }}" class="badge">+ Thêm mới</a>
                    </div>
                    <div class="product-list-grid">
                        @foreach($latestProducts as $product)
                            <div class="admin-product-card">
                                <div class="admin-product-image"></div>
                                <div class="admin-product-info">
                                    <h4>{{ $product->ten }}</h4>
                                    <p>{{ strlen($product->mota) > 60 ? substr($product->mota, 0, 60) . '...' : $product->mota }}</p>
                                    <span>{{ number_format($product->giaban, 0, ',', '.') }}đ</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="admin-grid">
                <div class="admin-panel">
                    <h3>Đơn hàng gần đây</h3>
                    <ul>
                        @foreach($recentOrders as $order)
                            <li>
                                <div>
                                    <strong>{{ $order->mavandon_formatted }}</strong>
                                    <div class="muted">{{ $order->ten }} - {{ $order->chiTietDonHangs->sum('soluong') }} sản phẩm</div>
                                </div>
                                <span class="badge">{{ $statuses[$order->trang_thai] ?? $order->trang_thai }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="admin-panel">
                    <h3>Hoạt động nhanh</h3>
                    <ul>
                        <li><span>Quản lý danh mục</span><a href="{{ route('category.index') }}" class="badge">Mở</a></li>
                        <li><span>Thêm sản phẩm mới</span><a href="{{ route('product.create') }}" class="badge">Thêm</a></li>
                        <li><span>Xem báo cáo bán hàng</span><a href="#" class="badge">Xem</a></li>
                    </ul>
                </div>
            </section>
@endsection
