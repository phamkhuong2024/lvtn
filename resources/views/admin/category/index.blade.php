@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col">
                <h2>Quản lý danh mục</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('category.create') }}" class="btn btn-success">Thêm danh mục mới</a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-info text-white">Về dashboard</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ route('category.index') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm danh mục...">
                        <button type="submit" class="btn btn-primary">Tìm</button>
                        @if(request('search'))
                            <a href="{{ route('category.index') }}" class="btn btn-secondary">Xóa</a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <span class="text-muted">Tổng số: <strong>{{ $categories->total() }}</strong> danh mục</span>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Mô tả</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->ten }}</td>
                                <td>{{ Str::limit($category->mota, 50) }}</td>
                                <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Chưa có danh mục nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
