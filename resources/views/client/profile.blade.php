@extends('layouts.client')
@section('title','Thông tin cá nhân')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4 text-primary">
        <i class="bi bi-person-circle me-2"></i> Thông tin cá nhân
    </h2>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4">
                    {{-- Ảnh đại diện --}}
                    <div class="text-center mb-4">
                        @php
                            $anh_dai_dien = auth()->user()->anh_dai_dien;
                        @endphp
                        @if($anh_dai_dien && Str::startsWith($anh_dai_dien, ['http://','https://']))
                            <img src="{{ $anh_dai_dien }}" alt="Avatar"
                                 class="rounded-circle border border-3 border-primary shadow-sm"
                                 style="width:120px;height:120px;object-fit:cover">
                        @else
                            <img src="{{ $anh_dai_dien ? asset('images/'.$anh_dai_dien) : 'https://via.placeholder.com/120' }}"
                                 alt="Avatar"
                                 class="rounded-circle border border-3 border-primary shadow-sm"
                                 style="width:120px;height:120px;object-fit:cover">
                        @endif
                        <h4 class="mt-3 fw-bold text-dark">{{ auth()->user()->ten_hien_thi }}</h4>
                        <p class="text-muted"><i class="bi bi-envelope me-1"></i>{{ auth()->user()->email }}</p>
                    </div>

                    {{-- Form chỉnh sửa --}}
                    <form action="{{ route('client.profile.update') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-medium"><i class="bi bi-person-fill me-2 text-primary"></i>Họ và tên</label>
                            <input type="text" name="ten_hien_thi" class="form-control rounded-pill"
                                   value="{{ old('ten_hien_thi',auth()->user()->ten_hien_thi) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium"><i class="bi bi-envelope-fill me-2 text-primary"></i>Email</label>
                            <input type="email" name="email" class="form-control rounded-pill"
                                   value="{{ old('email',auth()->user()->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium"><i class="bi bi-telephone-fill me-2 text-primary"></i>Số điện thoại</label>
                            <input type="text" name="sdt" class="form-control rounded-pill"
                                   value="{{ old('sdt',auth()->user()->sdt) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium"><i class="bi bi-image-fill me-2 text-primary"></i>Ảnh đại diện (URL hoặc tên file)</label>
                            <input type="text" name="anh_dai_dien" class="form-control rounded-pill"
                                   value="{{ old('anh_dai_dien',auth()->user()->anh_dai_dien) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium"><i class="bi bi-lock-fill me-2 text-primary"></i>Mật khẩu mới</label>
                            <input type="password" name="mat_khau" class="form-control rounded-pill"
                                   placeholder="Để trống nếu không đổi">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('client.orderslist') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="bi bi-arrow-left-circle me-1"></i> Quay lại đơn hàng
                            </a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-save me-1"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
