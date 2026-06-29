@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3>Chỉnh sửa nhân viên</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('nhanvien.index') }}">Nhân viên</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('nhanvien.update', $nhanvien->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tennv" class="form-label">Tên nhân viên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('tennv') is-invalid @enderror" 
                               id="tennv" name="tennv" value="{{ old('tennv', $nhanvien->tennv) }}" required>
                        @error('tennv')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $nhanvien->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="matkhau" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control @error('matkhau') is-invalid @enderror" 
                               id="matkhau" name="matkhau" placeholder="Để trống nếu không đổi mật khẩu">
                        @error('matkhau')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Chỉ nhập nếu muốn thay đổi mật khẩu</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sdt" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control @error('sdt') is-invalid @enderror" 
                               id="sdt" name="sdt" value="{{ old('sdt', $nhanvien->sdt) }}">
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
                            <option value="Nam" {{ old('gioitinh', $nhanvien->gioitinh) == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gioitinh', $nhanvien->gioitinh) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            <option value="Khác" {{ old('gioitinh', $nhanvien->gioitinh) == 'Khác' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gioitinh')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="chucvu" class="form-label">Chức vụ</label>
                        <input type="text" class="form-control @error('chucvu') is-invalid @enderror" 
                               id="chucvu" name="chucvu" value="{{ old('chucvu', $nhanvien->chucvu) }}">
                        @error('chucvu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ngayvaolam" class="form-label">Ngày vào làm</label>
                        <input type="date" class="form-control @error('ngayvaolam') is-invalid @enderror" 
                               id="ngayvaolam" name="ngayvaolam" 
                               value="{{ old('ngayvaolam', $nhanvien->ngayvaolam ? $nhanvien->ngayvaolam->format('Y-m-d') : '') }}">
                        @error('ngayvaolam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="diachi" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control @error('diachi') is-invalid @enderror" 
                               id="diachi" name="diachi" value="{{ old('diachi', $nhanvien->diachi) }}">
                        @error('diachi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-warning bg-gradient shadow text-dark">
                            <i class="fas fa-save"></i> Cập nhật nhân viên
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
