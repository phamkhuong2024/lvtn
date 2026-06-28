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
            <div class="filter-group">
                <button class="filter-btn active">Tất cả</button>
                <button class="filter-btn">Áo</button>
                <button class="filter-btn">Quần</button>
                <button class="filter-btn">Váy</button>
                <button class="filter-btn">Phụ kiện</button>
            </div>
            <div class="sort-box">
                <i class="fas fa-filter"></i>
                <span>Sắp xếp: Mới nhất</span>
            </div>
        </div>

        <div class="product-grid grid-4">
            @forelse($products as $product)
                <div class="product-card">
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
                </div>
            @empty
                <div class="empty-state">Chưa có sản phẩm nào để hiển thị.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
