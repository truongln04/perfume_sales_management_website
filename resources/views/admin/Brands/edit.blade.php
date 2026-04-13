@extends('layouts.admin')
@section('title','Sửa thương hiệu')
@section('header','Sửa thương hiệu')

@section('content')
<div class="container-fluid">
    <form action="{{ route('brands.update',$brand) }}" method="POST">@csrf @method('PUT')
        <div class="mb-3"><label>Tên thương hiệu</label><input name="ten_thuong_hieu" class="form-control" value="{{ $brand->ten_thuong_hieu }}" required></div>
        <div class="mb-3"><label>Quốc gia</label><input name="quoc_gia" class="form-control" value="{{ $brand->quoc_gia }}" required></div>
        <div class="mb-3"><label>Logo</label><input name="logo" class="form-control" value="{{ $brand->logo }}"></div>
        <button class="btn btn-success">Cập nhật</button>
        <a href="{{ route('brands.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
