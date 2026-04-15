@extends('layouts.admin')

@section('title', 'Thêm danh mục')
@section('header', 'Thêm danh mục')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold text-primary mb-3">Thêm mới danh mục</h3>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="ten_danh_muc" class="form-label">Tên danh mục</label>
            <input type="text" name="ten_danh_muc" id="ten_danh_muc"
                   class="form-control @error('ten_danh_muc') is-invalid @enderror"
                   value="{{ old('ten_danh_muc') }}" required>
            @error('ten_danh_muc')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô tả</label>
            <textarea name="mo_ta" id="mo_ta"
                      class="form-control @error('mo_ta') is-invalid @enderror"
                      rows="3">{{ old('mo_ta') }}</textarea>
            @error('mo_ta')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection