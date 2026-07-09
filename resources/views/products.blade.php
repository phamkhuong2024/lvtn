@extends('layouts.app')

@section('title', 'Sản phẩm - LK fashion')

@section('content')
<section class="products-page">
    <div class="container">
        <div class="products-hero">
            <div>
                <p class="eyebrow eyebrow-dark">Bộ sưu tập mới</p>
                <h1>Khám phá những món đồ nữ thời thượng</h1>
                <p>Danh sách sản phẩm được tuyển chọn kỹ lưỡng, phù hợp cho nhiều phong cách từ đi làm, dạo phố đến dự tiệc.</p>
            </div>
            <a href="#" class="btn-primary">Mua ngay</a>
        </div>

        <div class="products-toolbar">
            <div class="d-flex flex-wrap gap-3 align-items-center w-100">
                <form action="{{ route('products') }}" method="GET" class="d-flex flex-grow-1" style="gap: 8px;">
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Tìm kiếm sản phẩm theo tên, mô tả..." style="min-width: 220px;">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    @if(request('search'))
                        <a href="{{ route('products') }}" class="btn btn-secondary">Xóa</a>
                    @endif
                </form>
            </div>

            @if(request('search'))
                <div class="search-summary mt-3">
                    <p class="mb-0 text-muted">Kết quả tìm kiếm cho "<strong>{{ request('search') }}</strong>": <strong>{{ $products->total() }}</strong> sản phẩm</p>
                </div>
            @endif

            <div class="filter-group mt-3">
                <a href="{{ route('products', array_merge(request()->except(['page','category']), ['category' => ''])) }}" class="filter-btn {{ !request('category') ? 'active' : '' }}">Tất cả</a>
                <a href="{{ route('products', array_merge(request()->except(['page','category']), ['category' => 'ao'])) }}" class="filter-btn {{ request('category') == 'ao' ? 'active' : '' }}">Áo</a>
                <a href="{{ route('products', array_merge(request()->except(['page','category']), ['category' => 'quan'])) }}" class="filter-btn {{ request('category') == 'quan' ? 'active' : '' }}">Quần</a>
                <a href="{{ route('products', array_merge(request()->except(['page','category']), ['category' => 'vay'])) }}" class="filter-btn {{ request('category') == 'vay' ? 'active' : '' }}">Váy</a>
                <a href="{{ route('products', array_merge(request()->except(['page','category']), ['category' => 'phukien'])) }}" class="filter-btn {{ request('category') == 'phukien' ? 'active' : '' }}">Phụ kiện</a>
            </div>
            <div class="filter-group mt-3">
                <span class="filter-label">Giá:</span>
                <a href="{{ route('products', array_merge(request()->except(['page','price']), ['price' => ''])) }}" class="filter-btn {{ !request('price') ? 'active' : '' }}">Tất cả</a>
                <a href="{{ route('products', array_merge(request()->except(['page','price']), ['price' => '200000-500000'])) }}" class="filter-btn {{ request('price') == '200000-500000' ? 'active' : '' }}">200k - 500k</a>
                <a href="{{ route('products', array_merge(request()->except(['page','price']), ['price' => '500000-1000000'])) }}" class="filter-btn {{ request('price') == '500000-1000000' ? 'active' : '' }}">500k - 1 triệu</a>
            </div>
        </div>

        <div class="product-grid grid-4">
            @forelse($products as $product)
                <div class="product-card">
                    <a href="{{ route('product.show', $product->id) }}" class="product-link">
                        <div class="product-image">
                            <img src="{{ $product->hinhanh ?: 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=700&q=80' }}" alt="{{ $product->ten }}">
                            @if($product->noibat)
                                <div class="product-badge">Hot</div>
                            @elseif($product->giagiam && $product->giagiam < $product->giaban)
                                <div class="product-badge sale">-{{ round((($product->giaban - $product->giagiam) / $product->giaban) * 100) }}%</div>
                            @endif
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->ten }}</h3>
                            <div class="product-price">
                                <span class="price">{{ number_format($product->giagiam ?? $product->giaban, 0, ',', '.') }}đ</span>
                                @if($product->giagiam && $product->giagiam < $product->giaban)
                                    <span class="old-price">{{ number_format($product->giaban, 0, ',', '.') }}đ</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="empty-state">Chưa có sản phẩm nào để hiển thị.</div>
            @endforelse
        </div>

        <div class="pagination-wrapper mt-4 d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
@endsection
