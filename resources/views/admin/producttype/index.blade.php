@extends('layouts.admin')

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Header with title and add button -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fas fa-tags"></i> Quản lý Loại sản phẩm</h3>
    <a href="{{ route('producttype.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Thêm loại sản phẩm mới
    </a>
</div>

<!-- Search form -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form action="{{ route('producttype.index') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" 
                       placeholder="Tìm kiếm theo tên loại sản phẩm, mô tả hoặc danh mục..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
            @if(request('search'))
            <div class="col-12">
                <a href="{{ route('producttype.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-times"></i> Xóa bộ lọc
                </a>
                <span class="text-muted ms-2">Tìm kiếm: "{{ request('search') }}"</span>
            </div>
            @endif
        </form>
    </div>
</div>

<!-- Product Types table -->
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="10%">Hình ảnh</th>
                        <th width="20%">Tên loại</th>
                        <th width="15%">Danh mục</th>
                        <th width="25%">Mô tả</th>
                        <th width="8%" class="text-center">Nổi bật</th>
                        <th width="17%" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productTypes as $productType)
                    <tr>
                        <td><strong>{{ $productType->id }}</strong></td>
                        <td>
                            @if($productType->hinhanh)
                                <img src="{{ $productType->hinhanh }}" 
                                     alt="{{ $productType->ten }}" 
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 2px solid #dee2e6;">
                            @else
                                <div style="width: 60px; height: 60px; background-color: #f8f9fa; 
                                            border: 2px solid #dee2e6; border-radius: 8px; 
                                            display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong>{{ $productType->ten }}</strong></td>
                        <td>
                            <span class="badge bg-primary">{{ $productType->category->ten }}</span>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $productType->mota ? Str::limit($productType->mota, 50) : 'Không có mô tả' }}
                            </small>
                        </td>
                        <td class="text-center">
                            @if($productType->noibat)
                                <span class="badge bg-success">
                                    <i class="fas fa-star"></i> Có
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="far fa-star"></i> Không
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('producttype.edit', $productType->id) }}" 
                                   class="btn btn-warning btn-sm" 
                                   title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $productType->id }}"
                                        title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $productType->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $productType->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $productType->id }}">
                                                <i class="fas fa-exclamation-triangle"></i> Xác nhận xóa
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa loại sản phẩm này không?</p>
                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                @if($productType->hinhanh)
                                                    <img src="{{ $productType->hinhanh }}" 
                                                         alt="{{ $productType->ten }}" 
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; margin-right: 15px;">
                                                @else
                                                    <div style="width: 50px; height: 50px; background-color: #e9ecef; 
                                                                border-radius: 5px; margin-right: 15px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <strong>{{ $productType->ten }}</strong><br>
                                                    <small class="text-muted">{{ $productType->category->ten }}</small>
                                                </div>
                                            </div>
                                            <p class="text-danger mt-3 mb-0">
                                                <small><i class="fas fa-info-circle"></i> Lưu ý: Nếu loại sản phẩm này đang có sản phẩm, bạn sẽ không thể xóa.</small>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times"></i> Hủy
                                            </button>
                                            <form action="{{ route('producttype.destroy', $productType->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i> Xác nhận xóa
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-tags fa-3x mb-3" style="opacity: 0.3;"></i>
                                <p class="fs-5">
                                    @if(request('search'))
                                        Không tìm thấy loại sản phẩm nào phù hợp với từ khóa "<strong>{{ request('search') }}</strong>"
                                    @else
                                        Chưa có loại sản phẩm nào. <a href="{{ route('producttype.create') }}" class="text-decoration-none">Thêm loại sản phẩm mới</a>
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($productTypes->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Hiển thị <strong>{{ $productTypes->firstItem() ?? 0 }}</strong> đến <strong>{{ $productTypes->lastItem() ?? 0 }}</strong> 
                trong tổng số <strong>{{ $productTypes->total() }}</strong> loại sản phẩm
            </div>
            <div>
                {{ $productTypes->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
