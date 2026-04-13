@extends('layouts.admin')

@section('title', 'Sửa danh mục')
@section('header', 'Sửa danh mục')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold text-primary mb-3">Chỉnh sửa danh mục</h3>

    <form action="{{ route('categories.update', $dm->id_danh_muc) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="ten_danh_muc" class="form-label">Tên danh mục</label>
            <input type="text" name="ten_danh_muc" id="ten_danh_muc"
                   class="form-control @error('ten_danh_muc') is-invalid @enderror"
                   value="{{ old('ten_danh_muc', $dm->ten_danh_muc) }}" required>
            @error('ten_danh_muc')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô tả</label>
            <textarea name="mo_ta" id="mo_ta"
                      class="form-control @error('mo_ta') is-invalid @enderror"
                      rows="3">{{ old('mo_ta', $dm->mo_ta) }}</textarea>
            @error('mo_ta')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
