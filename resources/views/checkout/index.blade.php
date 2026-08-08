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
                            <option value="vnpay">VNPay Sandbox</option>
                            
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
                    
                    <!-- Voucher Section -->
                    <div class="voucher-section">
                        <div class="voucher-input-group">
                            <!-- <input type="text" id="voucherInput" class="form-control" placeholder="Nhập mã voucher" value="{{ $appliedVoucher['ten'] ?? '' }}" {{ $appliedVoucher ? 'disabled' : '' }}> -->
                            @if($appliedVoucher)
                                <button type="button" class="btn btn-danger" id="removeVoucherBtn">Xóa</button>
                            @else
                                <button type="button" class="btn btn-secondary" id="applyVoucherBtn">Áp dụng</button>
                            @endif
                        </div>
                        <div id="voucherMessage" class="voucher-message"></div>
                    </div>

                    @if($appliedVoucher)
                    <div class="summary-item discount-item">
                        <span>Giảm giá ({{ $appliedVoucher->ma_voucher }} - {{ $appliedVoucher->ten }})</span>
                        <span class="discount-amount">-{{ number_format($discount, 0, ',', '.') }}đ</span>
                    </div>
                    @endif
                    
                    <div class="summary-total">
                        <span>Tổng cộng</span>
                        <strong id="finalTotal">{{ number_format($finalTotal ?? $cartTotal, 0, ',', '.') }}đ</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const applyBtn = document.getElementById('applyVoucherBtn');
    const removeBtn = document.getElementById('removeVoucherBtn');
    const voucherInput = document.getElementById('voucherInput');
    const voucherMessage = document.getElementById('voucherMessage');
    const finalTotalElement = document.getElementById('finalTotal');
    const cartTotal = {{ $cartTotal }};

    if (applyBtn) {
        applyBtn.addEventListener('click', function() {
            const voucherName = voucherInput.value.trim();
            
            if (!voucherName) {
                showMessage('Vui lòng nhập mã voucher.', 'error');
                return;
            }

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('vouchers.apply') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    voucher_name: voucherName,
                    cart_total: cartTotal
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                    // Reload page to update UI
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Có lỗi xảy ra. Vui lòng thử lại.', 'error');
            });
        });
    }

    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('vouchers.remove') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                    // Reload page to update UI
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Có lỗi xảy ra. Vui lòng thử lại.', 'error');
            });
        });
    }

    function showMessage(message, type) {
        voucherMessage.textContent = message;
        voucherMessage.className = 'voucher-message ' + (type === 'success' ? 'success' : 'error');
        voucherMessage.style.display = 'block';
    }
});
</script>

<style>
.voucher-section {
    padding: 15px 0;
    border-top: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
    margin: 15px 0;
}

.voucher-input-group {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

.voucher-input-group input {
    flex: 1;
}

.voucher-message {
    display: none;
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 14px;
    margin-bottom: 10px;
}

.voucher-message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.voucher-message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.voucher-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: #007bff;
    text-decoration: none;
}

.voucher-link:hover {
    text-decoration: underline;
}

.discount-item {
    color: #28a745;
    font-weight: 600;
}

.discount-amount {
    color: #28a745;
}
</style>
@endsection
