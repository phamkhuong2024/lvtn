@extends('layouts.app')

@section('title', 'Giỏ hàng - LK fashion')

@section('content')
<div class="cart-page">
    <div class="container">
        <h1 class="page-title">Giỏ hàng của bạn</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($cartItems->isEmpty())
            <div class="empty-cart">
                <p>Giỏ hàng của bạn đang trống.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
            </div>
        @else
            <div class="cart-table-wrapper">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Chi tiết</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                        <tr>
                            <td class="product-thumb">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-fluid" style="max-width: 120px;">
                            </td>
                            <td>
                                <strong>{{ $item['name'] }}</strong>
                                <div>Màu: {{ $item['color_name'] }}</div>
                                <div>Kích cỡ: {{ $item['size_name'] }}</div>
                            </td>
                            <td>{{ number_format($item['price'], 0, ',', '.') }}đ</td>
                            <td>
                                <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $item['key'] }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}" class="form-control" style="width: 100px;">
                                    <button type="submit" class="btn btn-sm btn-secondary ms-2">Cập nhật</button>
                                </form>
                            </td>
                            <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</td>
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $item['key'] }}">
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="cart-summary">
                <div class="summary-box">
                    <h2>Tổng đơn hàng</h2>
                    <div class="summary-row">
                        <span>Tạm tính:</span>
                        <strong>{{ number_format($cartTotal, 0, ',', '.') }}đ</strong>
                    </div>
                    <div class="summary-actions">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">Tiếp tục mua sắm</a>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary">Thanh toán</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
