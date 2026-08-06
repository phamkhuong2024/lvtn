@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col">
                <h2>Quản lý thương hiệu</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('brand.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i>Thêm thương hiệu mới
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-info text-white">Về dashboard</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-md-8">
                <form action="{{ route('brand.index') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm theo tên hoặc mô tả thương hiệu...">
                        <select class="form-select" name="trang_thai" style="max-width: 180px;">
                            <option value="">Tất cả trạng thái</option>
                            <option value="1" {{ request('trang_thai') !== null && request('trang_thai') !== '' && request('trang_thai') == '1' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ request('trang_thai') !== null && request('trang_thai') !== '' && request('trang_thai') == '0' ? 'selected' : '' }}>Không hoạt động</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Tìm</button>
                        @if(request('search') || (request('trang_thai') !== null && request('trang_thai') !== ''))
                            <a href="{{ route('brand.index') }}" class="btn btn-secondary">Xóa lọc</a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="col-md-4 text-end d-flex align-items-center justify-content-end">
                <span class="text-muted">
                    Tổng số: <strong class="text-dark">{{ $brands->total() }}</strong> thương hiệu
                </span>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 70px;">ID</th>
                                <th style="width: 120px;">Logo</th>
                                <th>Tên thương hiệu</th>
                                <th style="width: 150px;">Slug</th>
                                <th>Mô tả</th>
                                <th style="width: 110px;">Trạng thái</th>
                                <th style="width: 130px;">Ngày tạo</th>
                                <th style="width: 180px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($brands as $brand)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $brand->id }}</span></td>
                                    <td>
                                        @if($brand->logo)
                                            <img src="{{ asset($brand->logo) }}" alt="{{ $brand->ten }}" class="img-thumbnail bg-light" style="width: 100px; height: 50px; object-fit: contain; border: 1px solid #eee;">
                                        @else
                                            <div class="text-muted text-center fst-italic py-2" style="width: 100px; height: 50px; border: 1px dashed #ddd; line-height: 38px;">
                                                No logo
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong class="d-block text-dark">{{ $brand->ten }}</strong>
                                        <small class="text-muted">
                                            <i class="fas fa-box me-1"></i>
                                            {{ $brand->products()->count() }} sản phẩm
                                        </small>
                                    </td>
                                    <td>
                                        <code class="text-primary small">{{ $brand->slug }}</code>
                                    </td>
                                    <td>
                                        {{ $brand->mo_ta ? Str::limit($brand->mo_ta, 50) : '<span class="text-muted fst-italic">Chưa có</span>' }}
                                    </td>
                                    <td>
                                        @if($brand->trang_thai)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Hoạt động
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-eye-slash me-1"></i>Ẩn
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $brand->created_at ? $brand->created_at->format('d/m/Y') : '—' }}
                                        </small>
                                    </td>
                                    <td>
                                        <a href="{{ route('brand.edit', $brand->id) }}" class="btn btn-sm btn-warning" title="Sửa">
                                            <i class="fas fa-edit me-1"></i>Sửa
                                        </a>
                                        <form action="{{ route('brand.destroy', $brand->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này?\nDữ liệu sẽ bị xóa vĩnh viễn.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                <i class="fas fa-trash me-1"></i>Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                        <h5>Chưa có thương hiệu nào</h5>
                                        <p class="mb-0">Hãy nhấp nút "Thêm thương hiệu mới" ở góc trên bên phải để bắt đầu.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($brands->total() > 0)
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $brands->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
