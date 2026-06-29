@extends('layouts.admin')

@section('content')
            <section class="admin-stats">
                <div class="stat-card">
                    <h3>Doanh thu hôm nay</h3>
                    <div class="value">2</div>
                    <div class="sub">+12% so với tháng trước</div>
                </div>
                <div class="stat-card">
                    <h3>Đơn hàng mới</h3>
                    <div class="value">128</div>
                    <div class="sub">8 cần xử lý</div>
                </div>
                <div class="stat-card">
                    <h3>Sản phẩm</h3>
                    <div class="value">342</div>
                    <div class="sub">+15 sản phẩm tháng này</div>
                </div>
                <div class="stat-card">
                    <h3>Khách hàng</h3>
                    <div class="value">2.3k</div>
                    <div class="sub">+96 người mới</div>
                </div>
            </section>

            <section class="admin-products-section" id="product-section">
                <div class="admin-panel">
                    <div class="panel-heading">
                        <h3>Danh sách sản phẩm</h3>
                        <a href="{{ route('product.create') }}" class="badge">+ Thêm mới</a>
                    </div>
                    <div class="product-list-grid">
                        <div class="admin-product-card">
                            <div class="admin-product-image"></div>
                            <div class="admin-product-info">
                                <h4>Áo khoác nữ</h4>
                                <p>Áo khoác nhẹ, phù hợp đi làm</p>
                                <span>890.000đ</span>
                            </div>
                        </div>
                        <div class="admin-product-card">
                            <div class="admin-product-image image-2"></div>
                            <div class="admin-product-info">
                                <h4>Áo thun basic</h4>
                                <p>Thoáng mát, dễ phối đồ</p>
                                <span>290.000đ</span>
                            </div>
                        </div>
                        <div class="admin-product-card">
                            <div class="admin-product-image image-3"></div>
                            <div class="admin-product-info">
                                <h4>Quần jeans slim</h4>
                                <p>Form ôm nhẹ, chất liệu bền</p>
                                <span>590.000đ</span>
                            </div>
                        </div>
                        <div class="admin-product-card">
                            <div class="admin-product-image image-4"></div>
                            <div class="admin-product-info">
                                <h4>Váy maxi linen</h4>
                                <p>Thanh lịch, thích hợp đi tiệc</p>
                                <span>650.000đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="admin-grid">
                <div class="admin-panel">
                    <h3>Đơn hàng gần đây</h3>
                    <ul>
                        <li>
                            <div>
                                <strong>Đơn #1024</strong>
                                <div class="muted">Nguyễn Thị An - 2 sản phẩm</div>
                            </div>
                            <span class="badge">Đang giao</span>
                        </li>
                        <li>
                            <div>
                                <strong>Đơn #1023</strong>
                                <div class="muted">Trần Minh Huy - 4 sản phẩm</div>
                            </div>
                            <span class="badge">Hoàn tất</span>
                        </li>
                        <li>
                            <div>
                                <strong>Đơn #1022</strong>
                                <div class="muted">Lê Thảo My - 1 sản phẩm</div>
                            </div>
                            <span class="badge">Chờ xác nhận</span>
                        </li>
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
