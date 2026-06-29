@extends('layouts.app')

@section('title', 'Đăng ký - LK fashion')

@section('content')
<section class="auth-page">
    <div class="container auth-container">
        <div class="auth-card">
            <div class="auth-brand">LK fashion</div>
            <h1>Tạo tài khoản</h1>
            <p>Đăng ký để nhận ưu đãi, theo dõi đơn hàng và mua sắm nhanh hơn.</p>

            <form class="auth-form" method="POST" action="{{ route('register.post') }}">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger text-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label for="ten">Họ và tên</label>
                <input id="ten" name="ten" type="text" class="auth-input" placeholder="Nhập họ và tên" value="{{ old('ten') }}" required>

                <label for="tendangnhap">Tên đăng nhập</label>
                <input id="tendangnhap" name="tendangnhap" type="text" class="auth-input" placeholder="Nhập tên đăng nhập" value="{{ old('tendangnhap') }}" required>

                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="auth-input" placeholder="Nhập email của bạn" value="{{ old('email') }}" required>

                <label for="sdt">Số điện thoại</label>
                <input id="sdt" name="sdt" type="text" class="auth-input" placeholder="Nhập số điện thoại" value="{{ old('sdt') }}">

                <label for="matkhau">Mật khẩu</label>
                <input id="matkhau" name="matkhau" type="password" class="auth-input" placeholder="Nhập mật khẩu" required>

                <label for="matkhau_confirmation">Xác nhận mật khẩu</label>
                <input id="matkhau_confirmation" name="matkhau_confirmation" type="password" class="auth-input" placeholder="Nhập lại mật khẩu" required>

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
