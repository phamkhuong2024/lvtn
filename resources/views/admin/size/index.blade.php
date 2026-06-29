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
    <h3><i class="fas fa-ruler"></i> Quản lý Kích cỡ</h3>
    <a href="{{ route('size.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Thêm kích cỡ mới
    </a>
</div>

<!-- Search form -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form action="{{ route('size.index') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" 
                       placeholder="Tìm kiếm theo tên kích cỡ..." 
                       value="{{ $search }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
            @if($search)
            <div class="col-12">
                <a href="{{ route('size.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-times"></i> Xóa bộ lọc
                </a>
                <span class="text-muted ms-2">Tìm kiếm: "{{ $search }}"</span>
            </div>
            @endif
        </form>
    </div>
</div>

<!-- Sizes table -->
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="10%">ID</th>
                        <th width="40%">Tên kích cỡ</th>
                        <th width="25%">Ngày tạo</th>
                        <th width="25%" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sizes as $size)
                    <tr>
                        <td><strong>{{ $size->id }}</strong></td>
                        <td>
                            <span class="badge bg-info text-dark fs-6 px-3 py-2">
                                {{ $size->ten }}
                            </span>
                        </td>
                        <td>{{ $size->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('size.edit', $size->id) }}" 
                                   class="btn btn-warning btn-sm" 
                                   title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <button type="button" 
                                        class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $size->id }}"
                                        title="Xóa">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </div>
                            
                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $size->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $size->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $size->id }}">
                                                <i class="fas fa-exclamation-triangle"></i> Xác nhận xóa
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa kích cỡ này không?</p>
                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                <div>
                                                    <strong class="fs-5">{{ $size->ten }}</strong>
                                                </div>
                                            </div>
                                            <p class="text-danger mt-3 mb-0">
                                                <small><i class="fas fa-info-circle"></i> Lưu ý: Nếu kích cỡ này đang được sử dụng trong sản phẩm, bạn sẽ không thể xóa.</small>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times"></i> Hủy
                                            </button>
                                            <form action="{{ route('size.destroy', $size->id) }}" method="POST" style="display: inline;">
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
                        <td colspan="4" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-ruler fa-3x mb-3" style="opacity: 0.3;"></i>
                                <p class="fs-5">
                                    @if($search)
                                        Không tìm thấy kích cỡ nào phù hợp với từ khóa "<strong>{{ $search }}</strong>"
                                    @else
                                        Chưa có kích cỡ nào
                                    @endif
                                </p>
                                @if(!$search)
                                <a href="{{ route('size.create') }}" class="btn btn-success mt-3">
                                    <i class="fas fa-plus"></i> Thêm kích cỡ đầu tiên
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($sizes->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Hiển thị {{ $sizes->firstItem() }} - {{ $sizes->lastItem() }} trong tổng số {{ $sizes->total() }} kích cỡ
            </div>
            <div>
                {{ $sizes->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
