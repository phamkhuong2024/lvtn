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
    <h3><i class="fas fa-palette"></i> Quản lý Màu sắc</h3>
    <a href="{{ route('color.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Thêm màu mới
    </a>
</div>

<!-- Search form -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form action="{{ route('color.index') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" 
                       placeholder="Tìm kiếm theo tên màu hoặc mã màu..." 
                       value="{{ $search }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
            @if($search)
            <div class="col-12">
                <a href="{{ route('color.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-times"></i> Xóa bộ lọc
                </a>
                <span class="text-muted ms-2">Tìm kiếm: "{{ $search }}"</span>
            </div>
            @endif
        </form>
    </div>
</div>

<!-- Colors table -->
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="8%">ID</th>
                        <th width="12%">Màu sắc</th>
                        <th width="25%">Tên màu</th>
                        <th width="20%">Mã màu</th>
                        <th width="15%">Ngày tạo</th>
                        <th width="20%" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($colors as $color)
                    <tr>
                        <td><strong>{{ $color->id }}</strong></td>
                        <td>
                            <div style="width: 60px; height: 40px; background-color: {{ $color->ma_mau }}; 
                                        border: 2px solid #dee2e6; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            </div>
                        </td>
                        <td><strong>{{ $color->ten }}</strong></td>
                        <td>
                            <code style="font-size: 14px; background-color: #f8f9fa; padding: 4px 8px; border-radius: 4px;">
                                {{ $color->ma_mau }}
                            </code>
                        </td>
                        <td>{{ $color->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('color.edit', $color->id) }}" 
                                   class="btn btn-warning btn-sm" 
                                   title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <button type="button" 
                                        class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $color->id }}"
                                        title="Xóa">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </div>
                            
                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $color->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $color->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $color->id }}">
                                                <i class="fas fa-exclamation-triangle"></i> Xác nhận xóa
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa màu sắc này không?</p>
                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                <div style="width: 40px; height: 40px; background-color: {{ $color->ma_mau }}; 
                                                            border: 2px solid #dee2e6; border-radius: 5px; margin-right: 15px;">
                                                </div>
                                                <div>
                                                    <strong>{{ $color->ten }}</strong><br>
                                                    <small class="text-muted">{{ $color->ma_mau }}</small>
                                                </div>
                                            </div>
                                            <p class="text-danger mt-3 mb-0">
                                                <small><i class="fas fa-info-circle"></i> Lưu ý: Nếu màu này đang được sử dụng trong sản phẩm, bạn sẽ không thể xóa.</small>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times"></i> Hủy
                                            </button>
                                            <form action="{{ route('color.destroy', $color->id) }}" method="POST" style="display: inline;">
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
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-palette fa-3x mb-3" style="opacity: 0.3;"></i>
                                <p class="fs-5">
                                    @if($search)
                                        Không tìm thấy màu sắc nào phù hợp với từ khóa "<strong>{{ $search }}</strong>"
                                    @else
                                        Chưa có màu sắc nào. <a href="{{ route('color.create') }}" class="text-decoration-none">Thêm màu mới</a>
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
        @if($colors->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Hiển thị <strong>{{ $colors->firstItem() ?? 0 }}</strong> đến <strong>{{ $colors->lastItem() ?? 0 }}</strong> 
                trong tổng số <strong>{{ $colors->total() }}</strong> màu sắc
            </div>
            <div>
                {{ $colors->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
