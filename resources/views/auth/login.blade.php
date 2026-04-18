@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-lg-10">
            <div class="card border-0 shadow-lg overflow-hidden rounded-4">
                <div class="row g-0">

                    <!-- Left: Form đăng nhập -->
                    <div class="col-md-6 bg-white p-5">
                        <h2 class="fw-bold text-primary mb-2">Đăng nhập</h2>
                        <p class="text-muted mb-4">
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
                                <div class="input-group">
                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="form-control rounded-start-3"
                                           placeholder="Nhập mật khẩu"
                                           required>
                                </div>
                            </div>

                            <!-- Quên mật khẩu -->
                            <div class="text-end mb-3">
                                <a href="{{ route('password.request') }}"
                                   class="small text-decoration-none">
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
                    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center p-5"
                         style="background: linear-gradient(135deg, #0d6efd, #6ea8fe); color: white;">

                        <h2 class="fw-bold mb-3">Xin chào!</h2>
                        <p class="mb-4 px-3">
                            Nếu bạn chưa có tài khoản, hãy đăng ký để sử dụng đầy đủ các chức năng của hệ thống.
                        </p>

                        <a href="{{ route('register') }}"
                           class="btn btn-light text-primary fw-semibold px-4 rounded-pill">
                            Đăng ký ngay
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection