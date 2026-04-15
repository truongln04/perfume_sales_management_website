@extends('layouts.admin')
@section('title','Sửa thương hiệu')
@section('header','Sửa thương hiệu')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0 text-primary fw-bold">Cập nhật thương hiệu</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.brands.update', $brand) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Tên thương hiệu --}}
                <div class="mb-3">
                    <label class="form-label">Tên thương hiệu</label>
                    <input type="text"
                           name="ten_thuong_hieu"
                           class="form-control"
                           value="{{ old('ten_thuong_hieu', $brand->ten_thuong_hieu) }}"
                           required>
                </div>

                {{-- Quốc gia --}}
                <div class="mb-3">
                    <label class="form-label">Quốc gia</label>
                    <input type="text"
                           name="quoc_gia"
                           class="form-control"
                           value="{{ old('quoc_gia', $brand->quoc_gia) }}"
                           required>
                </div>

                {{-- Logo URL --}}
                <div class="mb-3">
                    <label class="form-label">Logo từ URL</label>
                    <input type="text"
                           name="logo"
                           class="form-control"
                           placeholder="Nhập link ảnh logo..."
                           value="{{ old('logo', $brand->logo) }}">
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

                {{-- Ảnh hiện tại --}}
                @if($brand->logo)
                    <div class="mb-3">
                        <label class="form-label">Logo hiện tại</label>
                        <div>
                            <img src="{{ $brand->logo }}"
                                 alt="Logo"
                                 class="border rounded p-2 bg-white"
                                 style="max-width:180px; max-height:120px; object-fit:contain;">
                        </div>
                    </div>
                @endif

                {{-- Nút --}}
                <div class="mt-4">
<button type="submit" class="btn btn-success">
                        Cập nhật
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