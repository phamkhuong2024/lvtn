@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col">
                <h2>Quản lý mã giảm giá</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.vouchers.create') }}" class="btn btn-success">Thêm mã giảm giá mới</a>
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
            <div class="col-md-6 text-end ms-auto">
                <span class="text-muted">Tổng số: <strong>{{ $vouchers->total() }}</strong> mã giảm giá</span>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên mã</th>
                                <th>Loại</th>
                                <th>Giá trị giảm</th>
                                <th>Đơn tối thiểu</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vouchers as $voucher)
                                <tr>
                                    <td>{{ $voucher->id }}</td>
                                    <td>{{ $voucher->ten }}</td>
                                    <td>
                                        @if($voucher->loai_khuyen_mai === 'phan_tram')
                                            <span class="badge bg-info">Phần trăm</span>
                                        @else
                                            <span class="badge bg-primary">Số tiền</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($voucher->loai_khuyen_mai === 'phan_tram')
                                            {{ number_format($voucher->giatrigiam, 0) }}%
                                        @else
                                            {{ number_format($voucher->giatrigiam, 0, ',', '.') }}đ
                                        @endif
                                    </td>
                                    <td>
                                        @if($voucher->giatridonhang)
                                            {{ number_format($voucher->giatridonhang, 0, ',', '.') }}đ
                                        @else
                                            <span class="text-muted">Không yêu cầu</span>
                                        @endif
                                    </td>
                                    <td>{{ $voucher->ngaybatdau->format('d/m/Y') }}</td>
                                    <td>{{ $voucher->ngayketthuc->format('d/m/Y') }}</td>
                                    <td>
                                        @if($voucher->trangthai)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-secondary">Tạm dừng</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Chưa có mã giảm giá nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $vouchers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
