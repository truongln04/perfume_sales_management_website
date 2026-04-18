@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-lg-8">
            <div class="card border-0 shadow-lg overflow-hidden rounded-4">
                <div class="row g-0">

                    <!-- Left: Form quên mật khẩu -->
                    <div class="col-md-6 bg-white p-5">
                        <h2 class="fw-bold text-primary mb-2">Quên mật khẩu</h2>
                        <p class="text-muted mb-4">
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

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control rounded-3"
                                       placeholder="Nhập email của bạn"
                                       required>
                            </div>

                            <!-- Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary rounded-3">
                                    Gửi mã OTP
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection