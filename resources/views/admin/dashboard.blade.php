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

            <section class="admin-chart-section">
                <div class="admin-panel">
                    <div class="panel-heading">
                        <h3>Doanh thu theo nhân viên</h3>
                        <span class="badge">Bar chart</span>
                    </div>
                    @php
                        $employeeMaxRevenue = !empty($employeeRevenueStats) ? max(array_column($employeeRevenueStats, 'revenue')) : 0;
                        $employeeMaxRevenue = max($employeeMaxRevenue, 1);
                    @endphp
                    <div class="chart-grid">
                        @if(!empty($employeeRevenueStats))
                            @foreach($employeeRevenueStats as $employee)
                                <div class="chart-column">
                                    <div class="bar-track">
                                        <div class="bar-fill" style="height: {{ round(($employee['revenue'] / $employeeMaxRevenue) * 100) }}%"></div>
                                    </div>
                                    <div class="bar-label">{{ Str::limit($employee['name'], 12) }}</div>
                                    <div class="bar-value">{{ number_format($employee['revenue'], 0, ',', '.') }}₫</div>
                                </div>
                            @endforeach
                        @else
                            <p class="empty-chart">Chưa có dữ liệu doanh thu cho nhân viên.</p>
                        @endif
                    </div>
                </div>

                <div class="admin-panel">
                    <div class="panel-heading">
                        <h3>Doanh thu 6 tháng đầu năm</h3>
                        <span class="badge">Line chart</span>
                    </div>
                    @php
                        $lineMonths = collect(range(1, 6))->map(function ($month) use ($monthlyRevenueStats) {
                            $item = collect($monthlyRevenueStats)->firstWhere('month', $month);
                            return [
                                'label' => now()->month($month)->translatedFormat('M'),
                                'revenue' => $item['revenue'] ?? 0,
                            ];
                        });
                        $lineMaxRevenue = max($lineMonths->pluck('revenue')->toArray()) ?: 1;
                    @endphp
                    <div class="line-chart-wrap">
                        <svg viewBox="0 0 600 220" class="line-chart">
                            <line x1="40" y1="180" x2="560" y2="180" class="chart-axis" />
                            <line x1="40" y1="20" x2="40" y2="180" class="chart-axis" />
                            @for($i = 0; $i < 5; $i++)
                                <line x1="40" y1="{{ 30 + ($i * 30) }}" x2="560" y2="{{ 30 + ($i * 30) }}" class="chart-grid" />
                            @endfor
                            @php
                                $points = [];
                                $lineMonths->each(function ($item, $index) use (&$points, $lineMaxRevenue) {
                                    $x = 40 + ($index * 100);
                                    $y = 180 - (($item['revenue'] / $lineMaxRevenue) * 130);
                                    $points[] = ['x' => $x, 'y' => $y];
                                });
                            @endphp
                            @foreach($points as $index => $point)
                                @if($index > 0)
                                    <line x1="{{ $points[$index - 1]['x'] }}" y1="{{ $points[$index - 1]['y'] }}" x2="{{ $point['x'] }}" y2="{{ $point['y'] }}" class="line-path" />
                                @endif
                            @endforeach
                            @foreach($points as $point)
                                <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="5" class="line-point" />
                            @endforeach
                        </svg>
                        <div class="line-labels">
                            @foreach($lineMonths as $month)
                                <span>{{ $month['label'] }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="admin-panel">
                    <div class="panel-heading">
                        <h3>Số lượng danh mục</h3>
                        <span class="badge">Pie chart</span>
                    </div>
                    @php
                        $categoryTotal = array_sum(array_column($categoryDistributionStats, 'count')) ?: 1;
                    @endphp
                    <div class="pie-chart-wrap">
                        <svg viewBox="0 0 200 200" class="pie-chart">
                            @php
                                $startAngle = 0;
                                $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#ef4444'];
                            @endphp
                            @foreach($categoryDistributionStats as $index => $category)
                                @php
                                    $slice = ($category['count'] / $categoryTotal) * 360;
                                    $endAngle = $startAngle + $slice;
                                    $large = $slice > 180 ? 1 : 0;
                                    $x1 = 100 + 80 * cos(deg2rad($startAngle));
                                    $y1 = 100 + 80 * sin(deg2rad($startAngle));
                                    $x2 = 100 + 80 * cos(deg2rad($endAngle));
                                    $y2 = 100 + 80 * sin(deg2rad($endAngle));
                                    $startAngle = $endAngle;
                                @endphp
                                <path d="M100 100 L{{ $x1 }} {{ $y1 }} A80 80 0 {{ $large }} 1 {{ $x2 }} {{ $y2 }} Z" fill="{{ $colors[$index % count($colors)] }}"></path>
                            @endforeach
                            <circle cx="100" cy="100" r="45" fill="#fff"></circle>
                        </svg>
                        <ul class="legend-list">
                            @foreach($categoryDistributionStats as $index => $category)
                                <li><span class="legend-dot" style="background: {{ $colors[$index % count($colors)] }}"></span>{{ $category['name'] }} ({{ $category['count'] }})</li>
                            @endforeach
                        </ul>
                    </div>
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
