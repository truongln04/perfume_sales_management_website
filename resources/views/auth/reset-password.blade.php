@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-center align-items-center"
         style="min-height:100vh">

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

                <!-- OTP -->
                <div class="mb-3">
                    <input type="text"
                           name="code"
                           class="form-control rounded-3"
                           placeholder="Nhập mã xác thực"
                           required>
                </div>

                <!-- New Password -->
                <div class="mb-3">
                    <input type="password"
                           name="password"
                           class="form-control rounded-3"
                           placeholder="Nhập mật khẩu mới"
                           required>
                </div>

                <!-- Confirm Password -->
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