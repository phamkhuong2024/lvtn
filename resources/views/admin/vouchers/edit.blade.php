@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col">
                <h2>Sửa mã giảm giá</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('admin.vouchers.index') }}" class="btn btn-info text-white">Quay lại</a>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên mã giảm giá <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('ten') is-invalid @enderror"
                               id="ten" name="ten" value="{{ old('ten', $voucher->ten) }}" required>
                        @error('ten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Loại khuyến mãi <span class="text-danger">*</span></label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('loai_khuyen_mai') is-invalid @enderror" 
                                       type="radio" name="loai_khuyen_mai" id="loai_phan_tram" 
                                       value="phan_tram" 
                                       {{ old('loai_khuyen_mai', $voucher->loai_khuyen_mai) === 'phan_tram' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="loai_phan_tram">
                                    Phần trăm (%)
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('loai_khuyen_mai') is-invalid @enderror" 
                                       type="radio" name="loai_khuyen_mai" id="loai_so_tien" 
                                       value="so_tien" 
                                       {{ old('loai_khuyen_mai', $voucher->loai_khuyen_mai) === 'so_tien' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="loai_so_tien">
                                    Số tiền (đ)
                                </label>
                            </div>
                        </div>
                        @error('loai_khuyen_mai')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="giatrigiam" class="form-label">Giá trị giảm <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" 
                               class="form-control @error('giatrigiam') is-invalid @enderror"
                               id="giatrigiam" name="giatrigiam" 
                               value="{{ old('giatrigiam', $voucher->giatrigiam) }}" required>
                        <small class="form-text text-muted">
                            Nhập số phần trăm (0-100) hoặc số tiền tùy theo loại khuyến mãi
                        </small>
                        @error('giatrigiam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="giatridonhang" class="form-label">Giá trị đơn hàng tối thiểu</label>
                        <input type="number" step="0.01" min="0" 
                               class="form-control @error('giatridonhang') is-invalid @enderror"
                               id="giatridonhang" name="giatridonhang" 
                               value="{{ old('giatridonhang', $voucher->giatridonhang) }}">
                        <small class="form-text text-muted">
                            Để trống nếu không yêu cầu giá trị tối thiểu
                        </small>
                        @error('giatridonhang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ngaybatdau" class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('ngaybatdau') is-invalid @enderror"
                               id="ngaybatdau" name="ngaybatdau" 
                               value="{{ old('ngaybatdau', $voucher->ngaybatdau->format('Y-m-d')) }}" required>
                        @error('ngaybatdau')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ngayketthuc" class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('ngayketthuc') is-invalid @enderror"
                               id="ngayketthuc" name="ngayketthuc" 
                               value="{{ old('ngayketthuc', $voucher->ngayketthuc->format('Y-m-d')) }}" required>
                        @error('ngayketthuc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="trangthai" 
                                   id="trangthai" value="1" 
                                   {{ old('trangthai', $voucher->trangthai) ? 'checked' : '' }}>
                            <label class="form-check-label" for="trangthai">
                                Kích hoạt mã giảm giá
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-warning">Hủy</a>
                        <button type="submit" class="btn btn-success">Cập nhật mã giảm giá</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
