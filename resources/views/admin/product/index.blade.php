@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col">
                <h2>Quản lý sản phẩm</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('product.create') }}" class="btn btn-success">Thêm sản phẩm</a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-info text-white">Về dashboard</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ route('product.index') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm sản phẩm...">
                        <button type="submit" class="btn btn-primary">Tìm</button>
                        @if(request('search'))
                            <a href="{{ route('product.index') }}" class="btn btn-secondary">Xóa</a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <span class="text-muted">
                    Trang {{ $products->currentPage() }} - Hiển thị: <strong>{{ $products->count() }}</strong> / Tổng: <strong>{{ $products->total() }}</strong> sản phẩm
                </span>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá bán</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->ten }}</td>
                                <td>{{ $product->category?->ten ?? 'Chưa phân loại' }}</td>
                                <td>{{ number_format($product->giaban, 0, ',', '.') }}đ</td>
                                <td>
                                    @if($product->trangthai)
                                        <span class="badge bg-success">Hiển thị</span>
                                    @else
                                        <span class="badge bg-secondary">Ẩn</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Chưa có sản phẩm nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
