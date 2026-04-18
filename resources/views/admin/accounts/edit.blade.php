@extends('layouts.admin')

@section('content')
<div class="card mt-3 shadow-sm border-0">

    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <h5 class="m-0 text-primary fw-bold">Sửa tài khoản</h5>
    </div>

    <!-- Body -->
    <div class="card-body">
        <form action="{{ route('admin.accounts.update', $account->id_tai_khoan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <!-- Avatar -->
                <div class="col-md-12 text-center mb-2">
                    @if($account->anh_dai_dien)
                        <img src="{{ $account->anh_dai_dien }}"
                             width="90"
                             height="90"
                             class="rounded-circle border shadow-sm object-fit-cover">
                    @else
                        <div class="text-muted">Chưa có ảnh đại diện</div>
                    @endif
                </div>

                <!-- Tên hiển thị -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tên hiển thị</label>
                    <input type="text"
                           class="form-control"
                           name="ten_hien_thi"
                           value="{{ old('ten_hien_thi', $account->ten_hien_thi) }}">
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email"
                           class="form-control"
                           name="email"
                           value="{{ old('email', $account->email) }}">
                </div>

                <!-- SĐT -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Số điện thoại</label>
                    <input type="text"
                           class="form-control"
                           name="sdt"
                           value="{{ old('sdt', $account->sdt) }}">
                </div>

                <!-- Vai trò -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Vai trò</label>

                    @if($account->vai_tro == 'KHACHHANG')
                        <!-- Không cho đổi vai trò khách hàng -->
                        <input type="text"
                               class="form-control bg-light"
                               value="KHÁCH HÀNG"
                               readonly>

                        <input type="hidden"
                               name="vai_tro"
                               value="KHACHHANG">
                    @else
                        <!-- Các tài khoản khác vẫn sửa được -->
                        <select name="vai_tro" class="form-select">
                            <option value="ADMIN" {{ $account->vai_tro=='ADMIN'?'selected':'' }}>ADMIN</option>
                            <option value="NHANVIEN" {{ $account->vai_tro=='NHANVIEN'?'selected':'' }}>NHÂN VIÊN</option>
                            <option value="KHACHHANG" {{ $account->vai_tro=='KHACHHANG'?'selected':'' }}>KHÁCH HÀNG</option>
                        </select>
                    @endif
                </div>

                <!-- Google ID -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Google ID</label>
                    <input type="text"
                           class="form-control"
                           name="google_id"
                           value="{{ old('google_id', $account->google_id) }}">
                </div>

                <!-- Ảnh đại diện -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Link ảnh đại diện</label>
                    <input type="text"
                           class="form-control"
                           name="anh_dai_dien"
                           value="{{ old('anh_dai_dien', $account->anh_dai_dien) }}">
                </div>

                <!-- Mật khẩu -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Mật khẩu mới</label>
                    <input type="password"
                           class="form-control"
                           name="mat_khau"
                           placeholder="Để trống nếu không đổi mật khẩu">
                </div>

                <!-- Buttons -->
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        Cập nhật
                    </button>

                    <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">
                        Quay lại
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection