@extends('layouts.app')

@section('title', 'Hồ sơ Nhân viên')

@section('content')
<div class="profile-container" style="max-width: 800px; margin: 40px auto; padding: 20px;">
    <div class="profile-header" style="margin-bottom: 30px;">
        <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 10px;">Hồ sơ Nhân viên</h1>
        <p style="color: #666;">Quản lý thông tin cá nhân của bạn</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="padding: 15px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="padding: 15px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 8px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-card" style="background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 20px;">
        <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
            Thông tin cá nhân
        </h2>

        <form action="{{ route('nhanvien.profile.update') }}" method="POST">
            @csrf

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="tennv" style="display: block; font-weight: 500; margin-bottom: 8px; color: #333;">
                    Tên nhân viên <span style="color: red;">*</span>
                </label>
                <input 
                    type="text" 
                    id="tennv" 
                    name="tennv" 
                    value="{{ old('tennv', $nhanvien->tennv) }}"
                    required
                    style="width: 100%; padding: 12px 16px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; transition: border-color 0.3s;"
                    onfocus="this.style.borderColor='#28a745'"
                    onblur="this.style.borderColor='#ddd'"
                >
                @error('tennv')
                    <span style="color: #dc3545; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="email" style="display: block; font-weight: 500; margin-bottom: 8px; color: #333;">
                    Email <span style="color: red;">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $nhanvien->email) }}"
                    required
                    style="width: 100%; padding: 12px 16px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; transition: border-color 0.3s;"
                    onfocus="this.style.borderColor='#28a745'"
                    onblur="this.style.borderColor='#ddd'"
                >
                @error('email')
                    <span style="color: #dc3545; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="sdt" style="display: block; font-weight: 500; margin-bottom: 8px; color: #333;">
                    Số điện thoại
                </label>
                <input 
                    type="text" 
                    id="sdt" 
                    name="sdt" 
                    value="{{ old('sdt', $nhanvien->sdt) }}"
                    style="width: 100%; padding: 12px 16px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; transition: border-color 0.3s;"
                    onfocus="this.style.borderColor='#28a745'"
                    onblur="this.style.borderColor='#ddd'"
                >
                @error('sdt')
                    <span style="color: #dc3545; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="gioitinh" style="display: block; font-weight: 500; margin-bottom: 8px; color: #333;">
                    Giới tính
                </label>
                <select 
                    id="gioitinh" 
                    name="gioitinh"
                    style="width: 100%; padding: 12px 16px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; transition: border-color 0.3s;"
                    onfocus="this.style.borderColor='#28a745'"
                    onblur="this.style.borderColor='#ddd'"
                >
                    <option value="">-- Chọn giới tính --</option>
                    <option value="Nam" {{ old('gioitinh', $nhanvien->gioitinh) == 'Nam' ? 'selected' : '' }}>Nam</option>
                    <option value="Nữ" {{ old('gioitinh', $nhanvien->gioitinh) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                    <option value="Khác" {{ old('gioitinh', $nhanvien->gioitinh) == 'Khác' ? 'selected' : '' }}>Khác</option>
                </select>
                @error('gioitinh')
                    <span style="color: #dc3545; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="diachi" style="display: block; font-weight: 500; margin-bottom: 8px; color: #333;">
                    Địa chỉ
                </label>
                <textarea 
                    id="diachi" 
                    name="diachi" 
                    rows="3"
                    style="width: 100%; padding: 12px 16px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; transition: border-color 0.3s; resize: vertical;"
                    onfocus="this.style.borderColor='#28a745'"
                    onblur="this.style.borderColor='#ddd'"
                >{{ old('diachi', $nhanvien->diachi) }}</textarea>
                @error('diachi')
                    <span style="color: #dc3545; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="border-top: 2px solid #f0f0f0; margin: 30px 0; padding-top: 30px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 15px; color: #333;">
                    Thay đổi mật khẩu
                </h3>
                <p style="font-size: 14px; color: #666; margin-bottom: 20px;">
                    Để lại trống nếu không muốn thay đổi mật khẩu
                </p>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="matkhau" style="display: block; font-weight: 500; margin-bottom: 8px; color: #333;">
                        Mật khẩu mới
                    </label>
                    <input 
                        type="password" 
                        id="matkhau" 
                        name="matkhau" 
                        style="width: 100%; padding: 12px 16px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; transition: border-color 0.3s;"
                        onfocus="this.style.borderColor='#28a745'"
                        onblur="this.style.borderColor='#ddd'"
                    >
                    @error('matkhau')
                        <span style="color: #dc3545; font-size: 14px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="matkhau_confirmation" style="display: block; font-weight: 500; margin-bottom: 8px; color: #333;">
                        Xác nhận mật khẩu mới
                    </label>
                    <input 
                        type="password" 
                        id="matkhau_confirmation" 
                        name="matkhau_confirmation" 
                        style="width: 100%; padding: 12px 16px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; transition: border-color 0.3s;"
                        onfocus="this.style.borderColor='#28a745'"
                        onblur="this.style.borderColor='#ddd'"
                    >
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <button 
                    type="submit" 
                    style="padding: 12px 32px; background: #28a745; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 500; cursor: pointer; transition: background 0.3s;"
                    onmouseover="this.style.background='#218838'"
                    onmouseout="this.style.background='#28a745'"
                >
                    Cập nhật thông tin
                </button>

                <a 
                    href="/" 
                    style="padding: 12px 32px; background: #6c757d; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 500; text-decoration: none; display: inline-block; transition: background 0.3s;"
                    onmouseover="this.style.background='#545b62'"
                    onmouseout="this.style.background='#6c757d'"
                >
                    Hủy
                </a>
            </div>
        </form>
    </div>

    <div class="logout-section" style="background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.1); padding: 30px;">
        <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 15px; color: #333;">
            Đăng xuất
        </h2>
        <p style="color: #666; margin-bottom: 20px;">
            Đăng xuất khỏi tài khoản của bạn
        </p>
        <form action="{{ route('nhanvien.logout') }}" method="POST" style="display: inline;">
            @csrf
            <button 
                type="submit" 
                style="padding: 12px 32px; background: #dc3545; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 500; cursor: pointer; transition: background 0.3s;"
                onmouseover="this.style.background='#c82333'"
                onmouseout="this.style.background='#dc3545'"
            >
                Đăng xuất
            </button>
        </form>
    </div>
</div>
@endsection
