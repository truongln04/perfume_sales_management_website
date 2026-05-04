@extends('layouts.admin')

@section('content')
<div class="card mt-3 shadow-sm border-0">

    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <h5 class="m-0 text-primary fw-bold">Thêm tài khoản</h5>
    </div>

    <!-- Body -->
    <div class="card-body">
        <form action="{{ route('admin.accounts.store') }}" method="POST">
            @csrf

            <div class="row g-3">

                <!-- Avatar Preview -->
                <div class="col-md-12 text-center mb-2">
                    <div class="rounded-circle border shadow-sm d-inline-flex align-items-center justify-content-center bg-light"
                         style="width:90px; height:90px;">
                        <span class="text-muted small">Avatar</span>
                    </div>
                </div>

                <!-- Tên hiển thị -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tên hiển thị</label>
                    <input type="text"
                           class="form-control"
                           name="ten_hien_thi"
                           placeholder="Nhập tên hiển thị"
                           value="{{ old('ten_hien_thi') }}">
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email"
                           class="form-control"
                           name="email"
                           placeholder="Nhập email"
                           value="{{ old('email') }}">
                </div>

                <!-- SĐT -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Số điện thoại</label>
                    <input type="text"
                           class="form-control"
                           name="sdt"
                           placeholder="Nhập số điện thoại"
                           value="{{ old('sdt') }}">
                </div>

                <!-- Vai trò -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Vai trò</label>
                    <select name="vai_tro" class="form-select">
                        <option value="ADMIN">ADMIN</option>
                        <option value="NHANVIEN">NHÂN VIÊN</option>
                    </select>
                </div>

                <!-- Google ID -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Google ID</label>
                    <input type="text"
                           class="form-control"
                           name="google_id"
                           placeholder="Nhập Google ID (nếu có)"
                           value="{{ old('google_id') }}">
                </div>

                <!-- Ảnh đại diện -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Link ảnh đại diện</label>
                    <input type="text"
                           class="form-control"
                           name="anh_dai_dien"
                           placeholder="Dán URL ảnh đại diện"
                           value="{{ old('anh_dai_dien') }}">
                </div>

                <!-- Mật khẩu -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Mật khẩu</label>
                    <input type="password"
                           class="form-control"
                           name="mat_khau"
                           placeholder="Nhập mật khẩu">
                </div>

                <!-- Buttons -->
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        Lưu tài khoản
                    </button>

                    <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">
                        Hủy
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection