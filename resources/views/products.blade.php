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

        <div class="row">
            <aside class="col-3">
                <div class="category-sidebar">
                    <h4>Danh mục</h4>
                    <ul class="category-list">
                        <li>
                            <a href="{{ route('products', array_merge(request()->except(['page','category','category_id','type']), ['category_id' => ''])) }}" class="{{ !request('category_id') && !request('category') ? 'active' : '' }}">Tất cả <span class="count">({{ \App\Models\Product::where('trangthai', true)->count() }})</span></a>
                        </li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('products', array_merge(request()->except(['page','category','category_id','type']), ['category_id' => $cat->id])) }}" class="{{ request('category_id') == $cat->id ? 'active' : '' }}">{{ $cat->ten }} <span class="count">({{ $cat->products_count }})</span></a>
                            @if(request('category_id') == $cat->id && $productTypes->count() > 0)
                            <ul class="type-list">
                                @foreach($productTypes as $type)
                                <li>
                                    <a href="{{ route('products', array_merge(request()->except(['page','type']), ['type' => $type->id])) }}" class="{{ request('type') == $type->id ? 'active' : '' }}">{{ $type->ten }} <span class="count">({{ $type->products()->where('trangthai', true)->count() }})</span></a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <main class="col-9">
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
            </main>
        </div>

        <div class="pagination-wrapper mt-4 d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
<style>
/* Products page styles */
.products-page { padding: 36px 0; }
.products-hero h1 { font-size: 28px; margin-bottom: 6px; }
.products-toolbar { margin: 18px 0 28px; }

.filter-btn {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    border: 1px solid #eee;
    background: #fff;
    color: #333;
    margin-right: 8px;
    text-decoration: none;
    font-size: 14px;
}
.filter-btn.active { background: #111; color: #fff; border-color: #111; }

.category-sidebar { background: #fff; padding: 18px; border: 1px solid #f0f0f0; border-radius: 10px; box-shadow: 0 6px 18px rgba(16,24,40,0.03); position: sticky; top: 24px; }
.category-sidebar h4 { margin: 0 0 12px; font-size: 16px; }
.category-list { list-style: none; padding: 0; margin: 0; }
.category-list > li { margin-bottom: 8px; }
.category-list a { display: flex; justify-content: space-between; align-items: center; padding: 8px; border-radius: 8px; color: #222; text-decoration: none; }
.category-list a:hover { background: #fbfbfb; }
.category-list a.active { background: #111; color: #fff; }
.category-list .count { color: #888; font-size: 13px; }
.type-list { list-style: none; padding-left: 10px; margin-top: 8px; }
.type-list li { margin: 6px 0; }
.type-list a { color: #444; font-size: 14px; text-decoration: none; }
.type-list a.active { font-weight: 600; color: #111; }

.product-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
.product-card { background: #fff; border: 1px solid #f0f0f0; border-radius: 10px; overflow: hidden; transition: transform .15s ease, box-shadow .15s ease; position: relative; }
.product-card:hover { transform: translateY(-6px); box-shadow: 0 8px 30px rgba(2,6,23,0.08); }
.product-image img { width: 100%; height: 260px; object-fit: cover; display: block; }
.product-info { padding: 12px; }
.product-name { font-size: 15px; margin: 0 0 8px; }
.product-price .price { font-weight: 700; color: #111; }
.product-badge { position: absolute; top: 12px; left: 12px; padding: 6px 8px; background: #ff6b6b; color: #fff; border-radius: 6px; font-weight: 700; font-size: 13px; }
.product-badge.sale { background: #ff8c00; }

@media (max-width: 992px) {
    .product-grid { grid-template-columns: repeat(2, 1fr); }
    .col-3 { flex: 0 0 100%; max-width: 100%; margin-bottom: 16px; }
    .category-sidebar { position: relative; top: 0; }
}

@media (max-width: 576px) {
    .product-grid { grid-template-columns: 1fr; }
    .product-image img { height: 220px; }
}
</style>

@endsection
