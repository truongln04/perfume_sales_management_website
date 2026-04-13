@extends('layouts.admin')
@section('title','Sửa nhà cung cấp')
@section('header','Sửa nhà cung cấp')

@section('content')
<div class="container-fluid">
    <form action="{{ route('suppliers.update',$supplier) }}" method="POST">@csrf @method('PUT')
        <div class="mb-3">
            <label>Tên nhà cung cấp</label>
            <input name="ten_ncc" class="form-control" value="{{ $supplier->ten_ncc }}" required>
        </div>
        <div class="mb-3">
            <label>Địa chỉ</label>
            <input name="dia_chi" class="form-control" value="{{ $supplier->dia_chi }}" required>
        </div>
        <div class="mb-3">
            <label>Số điện thoại</label>
            <input name="sdt" class="form-control" value="{{ $supplier->sdt }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input name="email" type="email" class="form-control" value="{{ $supplier->email }}" required>
        </div>
        <div class="mb-3">
            <label>Ghi chú</label>
            <textarea name="ghi_chu" class="form-control">{{ $supplier->ghi_chu }}</textarea>
        </div>
        <button class="btn btn-success">Cập nhật</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
