@extends('layouts.app')

@section('title', 'Thanh toán - LK fashion')

@section('content')
<div class="checkout-page">
    <div class="container">
        <h1 class="page-title">Thanh toán</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="checkout-layout">
            <div class="checkout-form">
                <h2>Thông tin giao hàng</h2>
                <form action="{{ route('checkout.place') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" name="ten" value="{{ old('ten', Auth::guard('khachhang')->check() ? Auth::guard('khachhang')->user()->ten : '') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::guard('khachhang')->check() ? Auth::guard('khachhang')->user()->email : '') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="sdt" value="{{ old('sdt', Auth::guard('khachhang')->check() ? Auth::guard('khachhang')->user()->sdt : '') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="diachi" value="{{ old('diachi', Auth::guard('khachhang')->check() ? Auth::guard('khachhang')->user()->diachi : '') }}" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Phường</label>
                            <input type="text" name="phuong" value="{{ old('phuong') }}" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Quận</label>
                            <input type="text" name="quan" value="{{ old('quan') }}" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Thành phố</label>
                            <input type="text" name="thanhpho" value="{{ old('thanhpho') }}" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phương thức thanh toán</label>
                        <select name="phuongthuc" class="form-control" required>
                            <option value="cod">Thanh toán khi nhận hàng</option>
                            <option value="bank">Chuyển khoản</option>
                            <option value="stripe">Stripe Sandbox</option>
                            <option value="vnpay">VNPay Sandbox</option>
                            <option value="paypal">PayPal Sandbox</option>
                            <option value="vietqr">VietQR Sandbox</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <strong>Sandbox:</strong> Stripe, VNPay, PayPal và VietQR hiện được bật ở chế độ demo. Sau khi đặt hàng, hệ thống sẽ chuyển bạn tới trang thanh toán sandbox tương ứng.
                    </div>
                    <button type="submit" class="btn btn-primary">Đặt hàng</button>
                </form>
            </div>

            <div class="checkout-summary">
                <h2>Đơn hàng của bạn</h2>
                <div class="summary-box">
                    @foreach($cartItems as $item)
                    <div class="summary-item">
                        <div>
                            <strong>{{ $item['name'] }}</strong>
                            <div>Màu: {{ $item['color_name'] }}</div>
                            <div>Kích cỡ: {{ $item['size_name'] }}</div>
                        </div>
                        <div>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</div>
                    </div>
                    @endforeach
                    <div class="summary-total">
                        <span>Tổng cộng</span>
                        <strong>{{ number_format($cartTotal, 0, ',', '.') }}đ</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
