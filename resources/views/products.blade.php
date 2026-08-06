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

        @if(isset($brands) && $brands->count() > 0)
        <!-- Bảng các thương hiệu -->
        <div class="brand-panel mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="brand-panel-title m-0">
                    <i class="fas fa-trademark me-2 text-primary"></i>Thương hiệu nổi bật
                </h5>
                @if(request('brand_id'))
                    <a href="{{ route('products', request()->except(['page', 'brand_id'])) }}" class="btn btn-sm btn-outline-danger rounded-pill">
                        <i class="fas fa-times me-1"></i>Xóa lọc thương hiệu
                    </a>
                @endif
            </div>
            <div class="brand-grid">
                <a href="{{ route('products', request()->except(['page', 'brand_id'])) }}" 
                   class="brand-chip {{ !request('brand_id') ? 'active' : '' }}">
                    <span>Tất cả thương hiệu</span>
                </a>
                @foreach($brands as $b)
                <a href="{{ route('products', array_merge(request()->except(['page', 'brand_id']), ['brand_id' => $b->id])) }}" 
                   class="brand-chip {{ request('brand_id') == $b->id ? 'active' : '' }}">
                    @if($b->logo)
                        <img src="{{ asset($b->logo) }}" alt="{{ $b->ten }}" class="brand-chip-logo">
                    @else
                        <i class="fas fa-tag me-1 text-muted" style="font-size: 12px;"></i>
                    @endif
                    <span class="brand-chip-name">{{ $b->ten }}</span>
                    <span class="brand-chip-count">({{ $b->products_count }})</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <div class="row">
            <aside class="col-3">
                <div class="category-sidebar mb-4">
                    <h4><i class="fas fa-list me-2 text-primary"></i>Danh mục</h4>
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

                @if(isset($brands) && $brands->count() > 0)
                <div class="category-sidebar">
                    <h4><i class="fas fa-trademark me-2 text-primary"></i>Thương hiệu</h4>
                    <ul class="category-list">
                        <li>
                            <a href="{{ route('products', request()->except(['page', 'brand_id'])) }}" class="{{ !request('brand_id') ? 'active' : '' }}">
                                Tất cả <span class="count">({{ \App\Models\Product::where('trangthai', true)->count() }})</span>
                            </a>
                        </li>
                        @foreach($brands as $b)
                        <li>
                            <a href="{{ route('products', array_merge(request()->except(['page', 'brand_id']), ['brand_id' => $b->id])) }}" class="{{ request('brand_id') == $b->id ? 'active' : '' }}">
                                <span>
                                    @if($b->logo)
                                        <img src="{{ asset($b->logo) }}" alt="{{ $b->ten }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 6px; vertical-align: middle;">
                                    @endif
                                    {{ $b->ten }}
                                </span>
                                <span class="count">({{ $b->products_count }})</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
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
                            @if($product->brand)
                                <div class="product-brand text-muted mb-1" style="font-size: 12px;">
                                    <i class="fas fa-tag me-1"></i>{{ $product->brand->ten }}
                                </div>
                            @endif
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
                <div class="empty-state w-100 py-5 text-center text-muted card shadow-sm" style="grid-column: 1 / -1;">
                    <i class="fas fa-search fa-3x mb-3 text-secondary"></i>
                    <h5>Không tìm thấy sản phẩm nào!</h5>
                    <p class="mb-0">Thử tìm kiếm từ khóa khác hoặc bỏ các bộ lọc đang chọn.</p>
                </div>
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
.products-toolbar { margin: 18px 0 24px; }

.filter-btn {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #334155;
    margin-right: 8px;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.2s ease;
}
.filter-btn.active { background: #0f172a; color: #fff; border-color: #0f172a; font-weight: 600; }

/* Brand Panel Styles */
.brand-panel {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    padding: 18px 22px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
}
.brand-panel-title { font-size: 16px; font-weight: 700; color: #0f172a; }
.brand-grid { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
.brand-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 999px;
    color: #334155;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
}
.brand-chip:hover {
    transform: translateY(-2px);
    border-color: #ec4899;
    color: #ec4899;
    box-shadow: 0 6px 16px rgba(236, 72, 153, 0.15);
}
.brand-chip.active {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
    color: #ffffff;
    border-color: #0f172a;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.22);
}
.brand-chip.active .brand-chip-count { color: #f472b6; background: rgba(255, 255, 255, 0.18); }
.brand-chip-logo { width: 22px; height: 22px; object-fit: contain; border-radius: 50%; }
.brand-chip-count { font-size: 11px; color: #64748b; padding: 2px 7px; background: #f1f5f9; border-radius: 999px; }

.category-sidebar { background: #fff; padding: 18px; border: 1px solid #f0f0f0; border-radius: 14px; box-shadow: 0 6px 18px rgba(16,24,40,0.03); }
.category-sidebar h4 { margin: 0 0 12px; font-size: 15px; font-weight: 700; color: #0f172a; }
.category-list { list-style: none; padding: 0; margin: 0; }
.category-list > li { margin-bottom: 6px; }
.category-list a { display: flex; justify-content: space-between; align-items: center; padding: 8px 10px; border-radius: 8px; color: #334155; text-decoration: none; font-size: 14px; transition: background 0.2s ease; }
.category-list a:hover { background: #f8fafc; color: #ec4899; }
.category-list a.active { background: #0f172a; color: #fff; font-weight: 600; }
.category-list .count { color: #888; font-size: 12px; }
.type-list { list-style: none; padding-left: 10px; margin-top: 6px; }
.type-list li { margin: 4px 0; }
.type-list a { color: #64748b; font-size: 13px; text-decoration: none; }
.type-list a.active { font-weight: 700; color: #ec4899; }

.product-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
.product-card { background: #fff; border: 1px solid #f0f0f0; border-radius: 14px; overflow: hidden; transition: transform .2s ease, box-shadow .2s ease; position: relative; }
.product-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(15,23,42,0.1); }
.product-image img { width: 100%; height: 260px; object-fit: cover; display: block; }
.product-info { padding: 14px; }
.product-name { font-size: 15px; font-weight: 700; margin: 0 0 4px; color: #0f172a; }
.product-price .price { font-weight: 700; color: #ec4899; font-size: 15px; }
.product-price .old-price { font-size: 13px; color: #94a3b8; text-decoration: line-through; margin-left: 6px; }
.product-badge { position: absolute; top: 12px; left: 12px; padding: 5px 10px; background: #ef4444; color: #fff; border-radius: 999px; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
.product-badge.sale { background: linear-gradient(135deg, #f97316 0%, #ef4444 100%); }

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
