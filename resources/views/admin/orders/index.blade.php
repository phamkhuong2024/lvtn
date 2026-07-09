@extends('layouts.admin')

@section('content')
    <div class="admin-panel">
        <div class="panel-heading d-flex justify-content-between align-items-center">
            <h3>Quản lý đơn hàng</h3>
            <form class="d-flex" method="GET" action="{{ route($routeGroup . '.order.index') }}">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm me-2" placeholder="Tìm kiếm đơn hàng...">
                <select name="status" class="form-select form-select-sm me-2">
                    <option value="">Tất cả trạng thái</option>
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mã vận đơn</th>
                        <th>Khách hàng</th>
                        <th>Liên hệ</th>
                        <th>Tổng giá</th>
                        <th>Phương thức</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->mavandon_formatted }}</td>
                            <td>{{ $order->ten }}<br><small>{{ optional($order->khachHang)->ten }}</small></td>
                            <td>{{ $order->sdt }}<br><small>{{ $order->email }}</small></td>
                            <td>{{ number_format($order->tonggia, 0, ',', '.') }}₫</td>
                            <td>{{ strtoupper($order->phuongthuc) }}</td>
                            <td><span class="badge bg-secondary">{{ $statuses[$order->trang_thai] ?? $order->trang_thai }}</span></td>
                            <td>{{ optional($order->ngaydat)->format('d/m/Y H:i') }}</td>
                            <td><a href="{{ route($routeGroup . '.order.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Chi tiết</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Không có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
