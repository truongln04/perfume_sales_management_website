@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-lg-10">
            <div class="card border-0 shadow-lg overflow-hidden rounded-4">
                <div class="row g-0">

                    <!-- Left: Form đăng ký -->
                    <div class="col-md-6 bg-white p-5">
                        <h2 class="fw-bold text-success mb-2">Đăng ký</h2>
                        <p class="text-muted mb-4">
                            Tạo tài khoản mới để bắt đầu sử dụng hệ thống
                        </p>

                        {{-- Hiển thị lỗi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Tên hiển thị -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tên hiển thị</label>
                                <input type="text"
                                       name="ten_hien_thi"
                                       class="form-control rounded-3"
                                       placeholder="Nhập họ tên"
                                       value="{{ old('ten_hien_thi') }}"
                                       required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control rounded-3"
                                       placeholder="Nhập email"
                                       value="{{ old('email') }}"
                                       required>
                            </div>

                            <!-- SĐT -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Số điện thoại</label>
                                <input type="text"
                                       name="sdt"
                                       class="form-control rounded-3"
                                       placeholder="Nhập số điện thoại"
                                       value="{{ old('sdt') }}"
                                       required>
                            </div>

                            <!-- Mật khẩu -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Mật khẩu</label>
                                <input type="password"
                                       name="password"
                                       class="form-control rounded-3"
                                       placeholder="Nhập mật khẩu"
                                       required>
                            </div>

                            <!-- Nhập lại mật khẩu -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Nhập lại mật khẩu</label>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control rounded-3"
                                       placeholder="Nhập lại mật khẩu"
                                       required>
                            </div>

                            <!-- Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success rounded-3">
                                    Đăng ký
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Welcome -->
                    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center p-5"
                         style="background: linear-gradient(135deg, #198754, #8ad9b0); color: white;">

                        <h2 class="fw-bold mb-3">Chào mừng bạn!</h2>
                        <p class="mb-4 px-3">
                            Nếu bạn đã có tài khoản, hãy đăng nhập để tiếp tục sử dụng hệ thống.
                        </p>

                        <a href="{{ route('login') }}"
                           class="btn btn-light text-success fw-semibold px-4 rounded-pill">
                            Quay lại đăng nhập
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection