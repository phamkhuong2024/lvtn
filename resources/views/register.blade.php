@extends('layouts.app')

@section('title', 'Đăng ký - LK fashion')

@section('content')
<section class="auth-page">
    <div class="container auth-container">
        <div class="auth-card">
            <div class="auth-brand">LK fashion</div>
            <h1>Tạo tài khoản</h1>
            <p>Đăng ký để nhận ưu đãi, theo dõi đơn hàng và mua sắm nhanh hơn.</p>

            <form class="auth-form">
                <label for="name">Họ và tên</label>
                <input id="name" type="text" class="auth-input" placeholder="Nhập họ và tên" required>

                <label for="email">Email</label>
                <input id="email" type="email" class="auth-input" placeholder="Nhập email của bạn" required>

                <label for="password">Mật khẩu</label>
                <input id="password" type="password" class="auth-input" placeholder="Nhập mật khẩu" required>

                <label for="password_confirmation">Xác nhận mật khẩu</label>
                <input id="password_confirmation" type="password" class="auth-input" placeholder="Nhập lại mật khẩu" required>

                <button type="submit" class="btn-primary auth-submit">Đăng ký</button>
            </form>

            <div class="auth-links">
                <a href="{{ route('login') }}">Đã có tài khoản? Đăng nhập</a>
                <a href="/">Về trang chủ</a>
            </div>
        </div>
    </div>
</section>
@endsection
