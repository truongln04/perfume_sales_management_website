@extends('layouts.app')

@section('content')

<style>
    body {
        background: url('https://orchard.vn/wp-content/uploads/2026/02/don-ma-khoi-sac-mo-loi-len-huong2.webp') 
                    no-repeat center center fixed;
        background-size: cover;
        color: #fff;
    }

    body::before {
        content: "";
        position: fixed;
        inset: 0;
        background-color: rgba(0,0,0,0.5);
        z-index: -1;
    }

    .card {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(12px);
        border-radius: 1rem;
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff;
    }

    h2, p, label {
        color: #fff;
    }

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

                    <!-- Left: Form quên mật khẩu -->
                    <div class="col-md-6 p-5">
                        <h2 class="fw-bold mb-2">Quên mật khẩu</h2>
                        <p class="mb-4">
                            Nhập email của bạn để nhận mã OTP đặt lại mật khẩu
                        </p>

                        {{-- Thông báo --}}
                        @if(session('error'))
                            <div class="alert alert-danger py-2">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success py-2">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.send.code') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control rounded-3"
                                       placeholder="Nhập email của bạn"
                                       required>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary rounded-3">
                                    Gửi mã OTP
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Giới thiệu -->
                    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center p-5 login-right">
                        <h2 class="fw-bold mb-3">Xin chào!</h2>
                        <p class="mb-4 px-3">
                            Hãy nhập email để khôi phục mật khẩu và tiếp tục trải nghiệm hệ thống.
                        </p>
                        <a href="{{ route('login') }}"
                           class="btn btn-light fw-semibold px-4 rounded-pill">
                            Quay lại đăng nhập
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
