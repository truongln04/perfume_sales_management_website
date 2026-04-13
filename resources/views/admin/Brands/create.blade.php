@extends('layouts.admin')
@section('title','Thêm thương hiệu')
@section('header','Thêm thương hiệu')

@section('content')
<div class="container-fluid">
    <form action="{{ route('brands.store') }}" method="POST">@csrf
        <div class="mb-3"><label>Tên thương hiệu</label><input name="ten_thuong_hieu" class="form-control" required></div>
        <div class="mb-3"><label>Quốc gia</label><input name="quoc_gia" class="form-control" required></div>
        <div class="mb-3"><label>Logo</label><input name="logo" class="form-control"></div>
        <button class="btn btn-success">Lưu</button>
        <a href="{{ route('brands.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
