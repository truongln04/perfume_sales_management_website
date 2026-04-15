@extends('layouts.admin')
@section('title','Thêm thương hiệu')
@section('header','Thêm thương hiệu')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0 text-primary fw-bold">Thêm thương hiệu mới</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.brands.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                {{-- Tên thương hiệu --}}
                <div class="mb-3">
                    <label class="form-label">Tên thương hiệu</label>
                    <input type="text"
                           name="ten_thuong_hieu"
                           class="form-control"
                           value="{{ old('ten_thuong_hieu') }}"
                           required>
                </div>

                {{-- Quốc gia --}}
                <div class="mb-3">
                    <label class="form-label">Quốc gia</label>
                    <input type="text"
                           name="quoc_gia"
                           class="form-control"
                           value="{{ old('quoc_gia') }}"
                           required>
                </div>

                {{-- Logo URL --}}
                <div class="mb-3">
                    <label class="form-label">Logo từ URL</label>
                    <input type="text"
                           name="logo"
                           class="form-control"
                           placeholder="Nhập link ảnh logo..."
                           value="{{ old('logo') }}">
                    <small class="text-muted">
                        Có thể nhập link ảnh hoặc chọn file bên dưới.
                    </small>
                </div>

                {{-- Upload file --}}
                <div class="mb-3">
                    <label class="form-label">Hoặc chọn file logo</label>
                    <input type="file"
                           name="logo_file"
                           class="form-control"
                           accept="image/*">
                </div>

                {{-- Nút --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        Lưu
                    </button>

                    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                        Hủy
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection