@extends('layouts.admin')
@section('title','Thêm sản phẩm')
@section('header','Thêm sản phẩm')

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">@csrf
        <div class="mb-3">
            <label>Danh mục</label>
            <select name="id_danh_muc" class="form-select" required>
                <option value="">-- Chọn danh mục --</option>
                @foreach($categories as $dm)
                    <option value="{{ $dm->id_danh_muc }}">{{ $dm->ten_danh_muc }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Thương hiệu</label>
            <select name="id_thuong_hieu" class="form-select" required>
                <option value="">-- Chọn thương hiệu --</option>
                @foreach($brands as $th)
                    <option value="{{ $th->id_thuong_hieu }}">{{ $th->ten_thuong_hieu }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nhà cung cấp</label>
            <select name="id_ncc" class="form-select" required>
                <option value="">-- Chọn nhà cung cấp --</option>
                @foreach($suppliers as $ncc)
                    <option value="{{ $ncc->id_ncc }}">{{ $ncc->ten_ncc }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3"><label>Tên sản phẩm</label><input name="ten_san_pham" class="form-control" required></div>
        <div class="mb-3"><label>Mô tả</label><textarea name="mo_ta" class="form-control"></textarea></div>
        <div class="mb-3"><label>Hình ảnh</label><input type="file" name="hinh_anh" class="form-control"></div>
        {{-- <div class="mb-3"><label>Giá nhập</label><input type="number" name="gia_nhap" class="form-control"></div> --}}
        <div class="mb-3"><label>Giá bán</label><input type="number" name="gia_ban" class="form-control" required></div>
        <div class="mb-3"><label>Khuyến mãi (%)</label><input type="number" name="km_phan_tram" class="form-control"></div>
        {{-- <div class="mb-3"><label>Số lượng tồn</label><input type="number" name="so_luong_ton" class="form-control"></div> --}}
        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="trang_thai" class="form-select">
                <option value="1">Đang bán</option>
                <option value="0">Chưa bán</option>
            </select>
        </div>
        <button class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
