@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="mb-3">Chi tiết đơn hàng #{{ $order->id }}</h3>
                    <p><strong>Mã vận đơn:</strong> {{ $order->mavandon_formatted }}</p>
                    <p><strong>Trạng thái:</strong> {{ $statuses[$order->trang_thai] ?? $order->trang_thai }}</p>
                    <p><strong>Phương thức thanh toán:</strong> {{ strtoupper($order->phuongthuc) }}</p>
                    <p>
                        <strong>Trạng thái thanh toán:</strong>
                        @if($order->thanhToan)
                            @if($order->thanhToan->trangthai === 'da_thanh_toan')
                                <span class="badge bg-success">Đã thanh toán</span>
                                @if($order->thanhToan->ngaythanhtoan)
                                    <small class="text-muted">({{ $order->thanhToan->ngaythanhtoan->format('d/m/Y H:i') }})</small>
                                @endif
                            @elseif($order->thanhToan->trangthai === 'cho_thanh_toan')
                                <span class="badge bg-warning text-dark">Chờ thanh toán</span>
                            @elseif($order->thanhToan->trangthai === 'that_bai')
                                <span class="badge bg-danger">Thanh toán thất bại</span>
                            @else
                                <span class="badge bg-secondary">{{ $order->thanhToan->trangthai }}</span>
                            @endif
                        @else
                            <span class="badge bg-secondary">Chưa có thông tin</span>
                        @endif
                    </p>
                    <p><strong>Ngày đặt:</strong> {{ optional($order->ngaydat)->format('d/m/Y H:i') }}</p>
                    @if($order->ngaygiao)
                        <p><strong>Ngày giao dự kiến:</strong> {{ $order->ngaygiao->format('d/m/Y H:i') }}</p>
                    @endif

                    @if(!in_array($order->trang_thai, ['hoan_thanh', 'da_huy', 'dang_giao']))
                        <form method="POST" action="{{ route('khachhang.order.cancel', $order->id) }}" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">
                            @csrf
                            <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="mb-3">Thông tin khách hàng</h4>
                    <p><strong>Họ tên:</strong> {{ $order->ten }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->sdt }}</p>
                    <p><strong>Địa chỉ nhận hàng:</strong> {{ $order->diachi }}, {{ $order->phuong }}, {{ $order->quan }}, {{ $order->thanhpho }}</p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Sản phẩm trong đơn</h4>
                    <div class="table-responsive">
                        <table class="table">
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
                    <div class="d-flex justify-content-end mt-3">
                        <div>
                            <p class="mb-1"><strong>Phí giao hàng:</strong> {{ number_format($order->phigiaohang, 0, ',', '.') }}₫</p>
                            <p class="mb-0"><strong>Tổng thanh toán:</strong> {{ number_format($order->tonggia, 0, ',', '.') }}₫</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('home') }}" class="btn btn-secondary">Về trang chủ</a>
            </div>
        </div>
    </div>
</div>
@endsection
