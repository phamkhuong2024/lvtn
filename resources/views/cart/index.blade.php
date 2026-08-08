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
            <div class="row">
                <div class="col-lg-8">
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
                </div>

            <div class="col-lg-4">
            <div class="cart-summary">
                <!-- Phần voucher -->
                <div class="voucher-section mb-4">
                    <h3>Mã giảm giá</h3>
                    
                    @if($appliedVoucher)
                        <div class="alert alert-success d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $appliedVoucher->ma_voucher }}</strong> - {{ $appliedVoucher->ten }}
                                <br>
                                <small>Giảm: 
                                    @if($appliedVoucher->loai_khuyen_mai === 'phan_tram')
                                        {{ number_format($appliedVoucher->giatrigiam, 0) }}%
                                    @else
                                        {{ number_format($appliedVoucher->giatrigiam, 0, ',', '.') }}đ
                                    @endif
                                </small>
                            </div>
                            <form action="{{ route('cart.removeVoucher') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('cart.applyVoucher') }}" method="POST" class="mb-3">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="voucher_code" class="form-control" placeholder="Nhập mã voucher" required>
                                <button type="submit" class="btn btn-primary">Áp dụng</button>
                            </div>
                        </form>

                        @if($vouchers->isNotEmpty())
                            <div class="available-vouchers">
                                <h4>Voucher khả dụng:</h4>
                                <div class="vouchers-list">
                                    @foreach($vouchers as $voucher)
                                        <div class="voucher-card">
                                            <div class="voucher-info">
                                                <strong>{{ $voucher->ma_voucher }}</strong>
                                                <p class="mb-1">{{ $voucher->ten }}</p>
                                                <small class="text-muted">
                                                    Giảm: 
                                                    @if($voucher->loai_khuyen_mai === 'phan_tram')
                                                        {{ number_format($voucher->giatrigiam, 0) }}%
                                                    @else
                                                        {{ number_format($voucher->giatrigiam, 0, ',', '.') }}đ
                                                    @endif
                                                    @if($voucher->giatridonhang)
                                                        - Đơn tối thiểu: {{ number_format($voucher->giatridonhang, 0, ',', '.') }}đ
                                                    @endif
                                                </small>
                                                <br>
                                                <small class="text-muted">HSD: {{ $voucher->ngayketthuc->format('d/m/Y') }}</small>
                                            </div>
                                            <form action="{{ route('cart.applyVoucher') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="voucher_code" value="{{ $voucher->ma_voucher }}">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">Sử dụng</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                <div class="summary-box">
                    <h2>Tổng đơn hàng</h2>
                    <div class="summary-row">
                        <span>Tạm tính:</span>
                        <strong>{{ number_format($cartTotal, 0, ',', '.') }}đ</strong>
                    </div>
                    @if($appliedVoucher && $discount > 0)
                        <div class="summary-row text-success">
                            <span>Giảm giá:</span>
                            <strong>-{{ number_format($discount, 0, ',', '.') }}đ</strong>
                        </div>
                        <div class="summary-row">
                            <span>Thành tiền:</span>
                            <strong class="text-danger">{{ number_format($finalTotal, 0, ',', '.') }}đ</strong>
                        </div>
                    @endif
                    <div class="summary-actions">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">Tiếp tục mua sắm</a>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary">Thanh toán</a>
                    </div>
                </div>
            </div>
            </div>
        @endif
    </div>
</div>
@endsection
