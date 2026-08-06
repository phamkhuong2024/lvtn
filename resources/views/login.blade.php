@extends('layouts.app')

@section('title', 'Đăng nhập - LK fashion')

@section('content')
<section class="auth-page">
    <div class="container auth-container">
        <div class="auth-card">
            <div class="auth-brand">LK fashion</div>
            <h1>Đăng nhập</h1>
            <p>Chào mừng bạn trở lại. Vui lòng nhập thông tin tài khoản để tiếp tục mua sắm.</p>

            @if(session('success'))
                <div class="alert alert-success" style="padding: 15px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" style="padding: 15px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 8px; margin-bottom: 20px;">
                    @foreach($errors->all() as $error)
                        <p style="margin: 0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="auth-form" action="{{ route('login.post') }}" method="post">
                @csrf
                
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="auth-input" placeholder="Nhập email của bạn" value="{{ old('email') }}" required>

                <label for="password">Mật khẩu</label>
                <input id="password" name="password" type="password" class="auth-input" placeholder="Nhập mật khẩu" required>

                <button type="submit" class="btn-primary auth-submit">Đăng nhập</button>
            </form>

            <div class="auth-divider" style="margin: 20px 0; text-align: center; position: relative;">
                <span style="background: white; padding: 0 10px; position: relative; z-index: 1;">Hoặc</span>
                <div style="position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #ddd; z-index: 0;"></div>
            </div>

            <a href="{{ route('login.google') }}" class="btn-google auth-submit" style="display: block; width: 100%; padding: 12px; text-align: center; background: #4285f4; color: white; border-radius: 8px; text-decoration: none; font-weight: 500; margin-bottom: 20px;">
                <svg style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-right: 8px;" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M21.35,11.1H12.18V13.83H18.69C18.36,17.64 15.19,19.27 12.19,19.27C8.36,19.27 5,16.25 5,12C5,7.9 8.2,4.73 12.2,4.73C15.29,4.73 17.1,6.7 17.1,6.7L19,4.72C19,4.72 16.56,2 12.1,2C6.42,2 2.03,6.8 2.03,12C2.03,17.05 6.16,22 12.25,22C17.6,22 21.5,18.33 21.5,12.91C21.5,11.76 21.35,11.1 21.35,11.1V11.1Z" />
                </svg>
                Đăng nhập bằng Google
            </a>

            <div class="auth-links">
                <a href="{{ route('register') }}">Chưa có tài khoản? Đăng ký</a>
                <a href="/">Quay lại trang chủ</a>
            </div>
        </div>
    </div>
</section>
@endsection