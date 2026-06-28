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

            <div class="auth-links">
                <a href="{{ route('register') }}">Chưa có tài khoản? Đăng ký</a>
                <a href="/">Quay lại trang chủ</a>
            </div>
        </div>
    </div>
</section>
@endsection