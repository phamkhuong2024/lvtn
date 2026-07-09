@extends('layouts.admin')

@section('content')
    <div class="admin-panel">
        <div class="panel-heading d-flex justify-content-between align-items-center">
            <div>
                <h3>Chi tiết đơn hàng #{{ $order->id }}</h3>
                        <p class="text-muted mb-0">Mã vận đơn: {{ $order->mavandon_formatted }}</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card p-3 mb-3">
                    <h5>Thông tin khách hàng</h5>
                    <p><strong>Họ tên:</strong> {{ $order->ten }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>SĐT:</strong> {{ $order->sdt }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->diachi }}</p>
                    <p><strong>Phường / Quận:</strong> {{ $order->phuong }} / {{ $order->quan }}</p>
                    <p><strong>Thành phố:</strong> {{ $order->thanhpho }}</p>
                </div>
                <div class="card p-3 mb-3">
                    <h5>Thông tin đơn hàng</h5>
                    <p><strong>Phương thức:</strong> {{ strtoupper($order->phuongthuc) }}</p>
                    <p><strong>Trạng thái:</strong> {{ $statuses[$order->trang_thai] ?? $order->trang_thai }}</p>
                    <p><strong>Phí giao hàng:</strong> {{ number_format($order->phigiaohang, 0, ',', '.') }}₫</p>
                    <p><strong>Tổng giá:</strong> {{ number_format($order->tonggia, 0, ',', '.') }}₫</p>
                    <p><strong>Ngày đặt:</strong> {{ optional($order->ngaydat)->format('d/m/Y H:i') }}</p>
                    @if($order->ngaygiao)
                        <p><strong>Ngày giao:</strong> {{ $order->ngaygiao->format('d/m/Y H:i') }}</p>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 mb-3">
                    <h5>Cập nhật trạng thái</h5>
                    <form method="POST" action="{{ route($routeGroup . '.order.updateStatus', $order->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select name="trang_thai" class="form-select">
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ $order->trang_thai === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>

                <div class="card p-3">
                    <h5>Danh sách sản phẩm</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Thuộc tính</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->chiTietDonHangs as $item)
                                <tr>
                                    <td>{{ optional($item->chiTietSanPham->sanPham)->ten ?? 'Sản phẩm đã xóa' }}</td>
                                    <td>
                                        {{ optional($item->chiTietSanPham->mauSac)->ten ?? '' }}
                                        {{ optional($item->chiTietSanPham->kichCo)->ten ?? '' }}
                                    </td>
                                    <td>{{ $item->soluong }}</td>
                                    <td>{{ number_format($item->dongia, 0, ',', '.') }}₫</td>
                                    <td>{{ number_format($item->dongia * $item->soluong, 0, ',', '.') }}₫</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
