@extends('layouts.admin')
@section('title','Thêm nhà cung cấp')
@section('header','Thêm nhà cung cấp')

@section('content')
<div class="container-fluid">
    <form action="{{ route('suppliers.store') }}" method="POST">@csrf
        <div class="mb-3">
            <label>Tên nhà cung cấp</label>
            <input name="ten_ncc" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Địa chỉ</label>
            <input name="dia_chi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Số điện thoại</label>
            <input name="sdt" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input name="email" type="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ghi chú</label>
            <textarea name="ghi_chu" class="form-control"></textarea>
        </div>
        <button class="btn btn-success">Lưu</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
