@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h3>Quản lý nhân viên</h3>
            <a href="{{ route('nhanvien.create') }}" class="btn btn-success bg-gradient shadow-sm">
                <i class="fas fa-plus"></i> Thêm nhân viên
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-3">
        <div class="col-md-6">
            <form action="{{ route('nhanvien.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm nhân viên...">
                    <button type="submit" class="btn btn-primary">Tìm</button>
                    @if(request('search'))
                        <a href="{{ route('nhanvien.index') }}" class="btn btn-secondary">Xóa</a>
                    @endif
                </div>
            </form>
        </div>
        <div class="col-md-6 text-end">
            <span class="text-muted">Tổng số: <strong>{{ $nhanviens->total() }}</strong> nhân viên</span>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên nhân viên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Giới tính</th>
                            <th>Chức vụ</th>
                            <th>Ngày vào làm</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nhanviens as $nhanvien)
                        <tr>
                            <td>{{ $nhanvien->id }}</td>
                            <td>{{ $nhanvien->tennv }}</td>
                            <td>{{ $nhanvien->email }}</td>
                            <td>{{ $nhanvien->sdt ?? 'N/A' }}</td>
                            <td>{{ $nhanvien->gioitinh ?? 'N/A' }}</td>
                            <td>{{ $nhanvien->chucvu ?? 'N/A' }}</td>
                            <td>{{ $nhanvien->ngayvaolam ? $nhanvien->ngayvaolam->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('nhanvien.edit', $nhanvien->id) }}" class="btn btn-sm btn-info bg-gradient shadow-sm" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('nhanvien.destroy', $nhanvien->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger bg-gradient shadow-sm" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Chưa có nhân viên nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $nhanviens->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
