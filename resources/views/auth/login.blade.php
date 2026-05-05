@extends('layouts.app')

@section('content')

<style>
    body {
        background: url('https://orchard.vn/wp-content/uploads/2026/02/don-ma-khoi-sac-mo-loi-len-huong2.webp') 
                    no-repeat center center fixed;
        background-size: cover;
        color: #fff;
    }

    /* Overlay mờ phủ toàn trang */
    body::before {
        content: "";
        position: fixed;
        inset: 0;
        background-color: rgba(0,0,0,0.5);
        z-index: -1;
    }

    /* Card login với hiệu ứng kính mờ */
    .card {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(12px);
        border-radius: 1rem;
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff;
    }

    h2, p, label {
        color: #fff; /* chữ trắng nổi bật trên nền mờ */
    }

    /* Nút đăng nhập */
    .btn-primary {
        background: rgba(13, 110, 253, 0.85);
        border: none;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background: rgba(13, 110, 253, 1);
        transform: scale(1.02);
    }

    /* Nút Google và Đăng ký */
    .btn-light {
        background-color: rgba(255,255,255,0.85);
        color: #0d6efd;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-light:hover {
        background-color: rgba(255,255,255,1);
        color: #084298;
    }

    /* Phần bên phải cũng mờ mờ */
    .login-right {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        color: #fff;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-lg-10">
            <div class="card border-0 shadow-lg overflow-hidden rounded-4">
                <div class="row g-0">

                    <!-- Left: Form đăng nhập -->
                    <div class="col-md-6 p-5">
                        <h2 class="fw-bold mb-2">Đăng nhập</h2>
                        <p class="mb-4">
                            Chào mừng bạn quay trở lại hệ thống
                        </p>

                        {{-- Thông báo lỗi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger py-2">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        @if(session('status'))
                            <div class="alert alert-success py-2">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

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

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Mật khẩu</label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control rounded-3"
                                       placeholder="Nhập mật khẩu"
                                       required>
                            </div>

                            <!-- Quên mật khẩu -->
                            <div class="text-end mb-3">
                                <a href="{{ route('password.request') }}"
                                   class="small text-decoration-none text-light">
                                    Quên mật khẩu?
                                </a>
                            </div>

                            <!-- Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary rounded-3">
                                    Đăng nhập
                                </button>
                            </div>

                            <!-- Google -->
                            <div class="d-grid">
                                <a href="{{ url('/auth/google/redirect') }}"
                                   class="btn btn-light border rounded-3">
                                    Đăng nhập với Google
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Giới thiệu -->
                    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center p-5 login-right">
                        <h2 class="fw-bold mb-3">Xin chào!</h2>
                        <p class="mb-4 px-3">
                            Nếu bạn chưa có tài khoản, hãy đăng ký để sử dụng đầy đủ các chức năng của hệ thống.
                        </p>
                        <a href="{{ route('register') }}"
                           class="btn btn-light fw-semibold px-4 rounded-pill">
                            Đăng ký ngay
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
