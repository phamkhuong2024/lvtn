@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3>Thêm nhân viên mới</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('nhanvien.index') }}">Nhân viên</a></li>
                    <li class="breadcrumb-item active">Thêm mới</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('nhanvien.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tennv" class="form-label">Tên nhân viên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tennv') is-invalid @enderror" 
                               id="tennv" name="tennv" value="{{ old('tennv') }}" required>
                        @error('tennv')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="matkhau" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('matkhau') is-invalid @enderror" 
                               id="matkhau" name="matkhau" required>
                        @error('matkhau')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sdt" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control @error('sdt') is-invalid @enderror" 
                               id="sdt" name="sdt" value="{{ old('sdt') }}">
                        @error('sdt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="gioitinh" class="form-label">Giới tính</label>
                        <select class="form-select @error('gioitinh') is-invalid @enderror" 
                                id="gioitinh" name="gioitinh">
                            <option value="">Chọn giới tính</option>
                            <option value="Nam" {{ old('gioitinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gioitinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            <option value="Khác" {{ old('gioitinh') == 'Khác' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gioitinh')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="chucvu" class="form-label">Chức vụ</label>
                        <input type="text" class="form-control @error('chucvu') is-invalid @enderror" 
                               id="chucvu" name="chucvu" value="{{ old('chucvu') }}">
                        @error('chucvu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ngayvaolam" class="form-label">Ngày vào làm</label>
                        <input type="date" class="form-control @error('ngayvaolam') is-invalid @enderror" 
                               id="ngayvaolam" name="ngayvaolam" value="{{ old('ngayvaolam') }}">
                        @error('ngayvaolam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="diachi" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control @error('diachi') is-invalid @enderror" 
                               id="diachi" name="diachi" value="{{ old('diachi') }}">
                        @error('diachi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary bg-gradient shadow">
                            <i class="fas fa-save"></i> Lưu nhân viên
                        </button>
                        <a href="{{ route('nhanvien.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
