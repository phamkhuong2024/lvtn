@extends('layouts.app')

@section('title', 'Thanh toán thành công - LK fashion')

@section('content')
<div class="container" style="padding: 60px 0;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                    </div>
                    
                    <h1 class="mb-3">Thanh toán thành công!</h1>
                    <p class="text-muted mb-4">Cảm ơn bạn đã mua hàng tại LK fashion</p>
                    
                    <div class="order-summary bg-light p-4 rounded mb-4">
                        <h5 class="mb-3">Thông tin đơn hàng</h5>
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-start"><strong>Mã đơn hàng:</strong></td>
                                    <td class="text-end">{{ $order->mavandon }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start"><strong>Tổng tiền:</strong></td>
                                    <td class="text-end text-primary"><strong>{{ number_format($order->tonggia, 0, ',', '.') }}đ</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-start"><strong>Phương thức thanh toán:</strong></td>
                                    <td class="text-end text-capitalize">{{ strtoupper($order->phuongthuc) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-start"><strong>Trạng thái thanh toán:</strong></td>
                                    <td class="text-end">
                                        @if($order->thanhToan && $order->thanhToan->trangthai === 'da_thanh_toan')
                                            <span class="badge bg-success">Đã thanh toán</span>
                                        @else
                                            <span class="badge bg-warning">Chờ thanh toán</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-start"><strong>Trạng thái đơn hàng:</strong></td>
                                    <td class="text-end">
                                        @if($order->trang_thai === 'dang_xu_ly')
                                            <span class="badge bg-info">Đang xử lý</span>
                                        @elseif($order->trang_thai === 'cho_xac_nhan')
                                            <span class="badge bg-secondary">Chờ xác nhận</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $order->trang_thai }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Thông báo:</strong> Chúng tôi đã gửi email xác nhận đơn hàng đến <strong>{{ $order->email }}</strong>
                    </div>

                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        @if(Auth::guard('khachhang')->check())
                            <a href="{{ route('khachhang.order.show', $order->id) }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-box me-2"></i>Xem chi tiết đơn hàng
                            </a>
                            <a href="{{ route('khachhang.order.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-list me-2"></i>Đơn hàng của tôi
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập để xem chi tiết
                            </a>
                        @endif
                        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-home me-2"></i>Về trang chủ
                        </a>
                    </div>

                    <div class="mt-4 pt-4 border-top">
                        <p class="text-muted mb-0">
                            <small>
                                Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi qua hotline: 
                                <strong>1900 xxxx</strong>
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order-summary {
    border: 1px solid #e3e6f0;
}
.order-summary .table td {
    padding: 8px 0;
}
</style>
@endsection
