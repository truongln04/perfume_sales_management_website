@extends('layouts.admin')

@section('title', 'Chỉnh sửa hồ sơ')
@section('header', 'Chỉnh sửa hồ sơ')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    {{-- QUAN TRỌNG: thêm enctype --}}
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Tên --}}
                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" name="ten_hien_thi"
                                   class="form-control"
                                   value="{{ old('ten_hien_thi', auth()->user()->ten_hien_thi) }}"
                                   required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   class="form-control"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   required>
                        </div>

                        {{-- SĐT --}}
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="sdt"
                                   class="form-control"
                                   value="{{ old('sdt', auth()->user()->sdt) }}">
                        </div>

                        {{-- Avatar URL --}}
                        <div class="mb-3">
                            <label class="form-label">Ảnh đại diện từ URL</label>
                            <input type="text"
                                   name="anh_dai_dien"
                                   class="form-control"
                                   placeholder="Nhập link ảnh..."
                                   value="{{ old('anh_dai_dien', auth()->user()->anh_dai_dien) }}">
                            <small class="text-muted">
                                Có thể nhập link ảnh hoặc chọn file bên dưới.
                            </small>
                        </div>

                        {{-- Upload file --}}
                        <div class="mb-3">
                            <label class="form-label">Hoặc chọn file ảnh</label>
                            <input type="file"
                                   name="avatar_file"
                                   class="form-control"
                                   accept="image/*">
                        </div>

                        {{-- Preview --}}
                        <div class="mb-3 text-center">
                            @php
                                $avatar = auth()->user()->anh_dai_dien;
                            @endphp

                            <img id="previewAvatar"
                                 src="{{ $avatar ? (Str::startsWith($avatar, ['http','https']) ? $avatar : asset('images/'.$avatar)) : 'https://via.placeholder.com/120' }}"
                                 class="rounded-circle border"
                                 style="width:100px;height:100px;object-fit:cover">
                        </div>

                        {{-- Mật khẩu --}}
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="mat_khau"
                                   class="form-control"
                                   placeholder="Để trống nếu không đổi">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.profile') }}"
                               class="btn btn-secondary">
                                Quay lại
                            </a>

                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save me-1"></i> Lưu
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// preview link
document.querySelector('input[name="anh_dai_dien"]')?.addEventListener('input', function(e) {
    document.getElementById('previewAvatar').src = e.target.value;
});

// preview file
document.querySelector('input[name="avatar_file"]')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewAvatar').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endpush