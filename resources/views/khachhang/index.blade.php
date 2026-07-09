@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Danh Sách Khách Hàng</h1>
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

                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('khachhang.index') }}" method="GET">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm khách hàng..." value="{{ request('search') }}" name="search">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <input type="number" name="min_items" value="{{ request('min_items') }}" class="form-control" placeholder="Từ số SP mua">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="max_items" value="{{ request('max_items') }}" class="form-control" placeholder="Đến số SP mua">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <button type="submit" class="btn btn-primary">Lọc</button>
                                    <a href="{{ route('khachhang.index') }}" class="btn btn-outline-secondary">Xóa lọc</a>
                                </div>
                            </div>
                        </form>
                        <div class="row mb-3">
                            <div class="col-md-12 text-end">
                                <span class="text-muted">Tổng số: <strong>{{ $khachhangs->total() }}</strong> khách hàng</span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tên đăng nhập</th>
                                        <th scope="col">Họ tên</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Số điện thoại</th>
                                        <th scope="col">SP đã mua</th>
                                        <th scope="col">Ngày sinh</th>
                                        <th scope="col">Giới tính</th>
                                        <th scope="col">Địa chỉ</th>
                                        <th scope="col" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($khachhangs as $index => $khachhang)
                                        <tr>
                                            <td>{{ $khachhangs->firstItem() + $index }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $khachhang->tendangnhap }}</span>
                                            </td>
                                            <td>{{ $khachhang->ten }}</td>
                                            <td>
                                                <a href="mailto:{{ $khachhang->email }}" class="text-decoration-none">
                                                    <i class="bi bi-envelope"></i> {{ $khachhang->email }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($khachhang->sdt)
                                                    <a href="tel:{{ $khachhang->sdt }}" class="text-decoration-none">
                                                        <i class="bi bi-telephone"></i> {{ $khachhang->sdt }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $khachhang->total_items_purchased ?? 0 }}</td>
                                            <td>
                                                @if($khachhang->ngaysinh)
                                                    {{ $khachhang->ngaysinh->format('d/m/Y') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($khachhang->gioitinh)
                                                    @if($khachhang->gioitinh == 'Nam')
                                                        <span class="badge bg-info"><i class="bi bi-gender-male"></i> Nam</span>
                                                    @elseif($khachhang->gioitinh == 'Nữ')
                                                        <span class="badge bg-warning"><i class="bi bi-gender-female"></i> Nữ</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $khachhang->gioitinh }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($khachhang->diachi)
                                                    <small>{{ Str::limit($khachhang->diachi, 30) }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $khachhang->id }}" title="Xem chi tiết">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Chi tiết -->
                                        <div class="modal fade" id="detailModal{{ $khachhang->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $khachhang->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="detailModalLabel{{ $khachhang->id }}">
                                                            <i class="bi bi-person-circle"></i> Chi tiết khách hàng
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <strong><i class="bi bi-person-badge"></i> Tên đăng nhập:</strong>
                                                                <p class="text-muted">{{ $khachhang->tendangnhap }}</p>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <strong><i class="bi bi-person"></i> Họ tên:</strong>
                                                                <p class="text-muted">{{ $khachhang->ten }}</p>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <strong><i class="bi bi-envelope"></i> Email:</strong>
                                                                <p class="text-muted">{{ $khachhang->email }}</p>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <strong><i class="bi bi-telephone"></i> Số điện thoại:</strong>
                                                                <p class="text-muted">{{ $khachhang->sdt ?? '-' }}</p>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <strong><i class="bi bi-calendar"></i> Ngày sinh:</strong>
                                                                <p class="text-muted">{{ $khachhang->ngaysinh ? $khachhang->ngaysinh->format('d/m/Y') : '-' }}</p>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <strong><i class="bi bi-gender-ambiguous"></i> Giới tính:</strong>
                                                                <p class="text-muted">{{ $khachhang->gioitinh ?? '-' }}</p>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <strong><i class="bi bi-geo-alt"></i> Địa chỉ:</strong>
                                                                <p class="text-muted">{{ $khachhang->diachi ?? '-' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                                <p class="text-muted mt-2">Chưa có khách hàng nào</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Hiển thị {{ $khachhangs->firstItem() ?? 0 }} đến {{ $khachhangs->lastItem() ?? 0 }} trong tổng số {{ $khachhangs->total() }} khách hàng
                            </div>
                            <div>
                                {{ $khachhangs->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
</div>
@endsection
