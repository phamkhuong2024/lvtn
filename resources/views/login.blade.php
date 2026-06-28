@extends('layouts.app')

@section('title', 'Đăng nhập - LK fashion')

@section('content')
<section class="auth-page">
    <div class="container auth-container">
        <div class="auth-card">
            <div class="auth-brand">LK fashion</div>
            <h1>Đăng nhập</h1>
            <p>Chào mừng bạn trở lại. Vui lòng nhập thông tin tài khoản để tiếp tục mua sắm.</p>

            <form class="auth-form" action="{{ route('admin.dashboard') }}" method="get">
                <label for="email">Email</label>
                <input id="email" type="email" class="auth-input" placeholder="Nhập email của bạn" required>

                <label for="password">Mật khẩu</label>
                <input id="password" type="password" class="auth-input" placeholder="Nhập mật khẩu" required>

                <button type="submit" class="btn-primary auth-submit">Đăng nhập</button>
            </form>

            <div class="auth-links">
                <a href="{{ route('register') }}">Chưa có tài khoản? Đăng ký</a>
                <a href="/">Quay lại trang chủ</a>
            </div>
        </div>
    </div>
</section>
@endsection