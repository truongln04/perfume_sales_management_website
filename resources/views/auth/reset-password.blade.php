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

    h3, p, label {
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

    .btn-warning {
        background: rgba(255,193,7,0.85);
        border: none;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-warning:hover {
        background: rgba(255,193,7,1);
        transform: scale(1.02);
    }

    .btn-outline-primary {
        border: 1px solid rgba(255,255,255,0.7);
        color: #fff;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-outline-primary:hover {
        background: rgba(255,255,255,0.2);
        color: #0d6efd;
    }
</style>

<div class="container-fluid px-0">
    <div class="d-flex justify-content-center align-items-center min-vh-100">

        <div class="card border-0 shadow-lg rounded-4 p-4 mx-3"
             style="max-width:480px; width:100%;">

            <h3 class="text-center fw-bold mb-4 text-primary">
                Đặt lại mật khẩu
            </h3>

            <p class="text-center text-muted mb-4">
                Email: <strong>{{ $email }}</strong>
            </p>

            {{-- Thông báo lỗi --}}
            @if(session('error'))
                <div class="alert alert-danger mb-3">
                    <strong>Lỗi:</strong> {{ session('error') }}
                </div>
            @endif

            {{-- Thành công --}}
            @if(session('success'))
                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form reset password -->
            <form method="POST" action="{{ route('password.confirm.reset') }}">
                @csrf

                <div class="mb-3">
                    <input type="text"
                           name="code"
                           class="form-control rounded-3"
                           placeholder="Nhập mã xác thực"
                           required>
                </div>

                <div class="mb-3">
                    <input type="password"
                           name="password"
                           class="form-control rounded-3"
                           placeholder="Nhập mật khẩu mới"
                           required>
                </div>

                <div class="mb-3">
                    <input type="password"
                           name="password_confirmation"
                           class="form-control rounded-3"
                           placeholder="Xác nhận mật khẩu mới"
                           required>
                </div>

                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-primary rounded-3">
                        Đặt lại mật khẩu
                    </button>
                </div>
            </form>

            <!-- Resend OTP -->
            <form method="POST" action="{{ route('password.resend') }}">
                @csrf
                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-warning rounded-3">
                        Gửi lại mã OTP
                    </button>
                </div>
            </form>

            <!-- Back login -->
            <div class="d-grid">
                <a href="{{ route('login') }}"
                   class="btn btn-outline-primary rounded-3">
                    Quay lại đăng nhập
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
