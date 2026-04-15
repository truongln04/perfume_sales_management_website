@extends('layouts.admin')
@section('title','Sửa sản phẩm')
@section('header','Sửa sản phẩm')

@section('content')
<div class="container-fluid">
    <form action="{{ route('products.update',$product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Danh mục</label>
            <select name="id_danh_muc" class="form-select" required>
                <option value="">-- Chọn danh mục --</option>
                @foreach($categories as $dm)
                    <option value="{{ $dm->id_danh_muc }}" {{ $product->id_danh_muc == $dm->id_danh_muc ? 'selected' : '' }}>
                        {{ $dm->ten_danh_muc }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Thương hiệu</label>
            <select name="id_thuong_hieu" class="form-select" required>
                <option value="">-- Chọn thương hiệu --</option>
                @foreach($brands as $th)
                    <option value="{{ $th->id_thuong_hieu }}" {{ $product->id_thuong_hieu == $th->id_thuong_hieu ? 'selected' : '' }}>
                        {{ $th->ten_thuong_hieu }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nhà cung cấp</label>
            <select name="id_ncc" class="form-select" required>
                <option value="">-- Chọn nhà cung cấp --</option>
                @foreach($suppliers as $ncc)
                    <option value="{{ $ncc->id_ncc }}" {{ $product->id_ncc == $ncc->id_ncc ? 'selected' : '' }}>
                        {{ $ncc->ten_ncc }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tên sản phẩm</label>
            <input name="ten_san_pham" class="form-control" value="{{ $product->ten_san_pham }}" required>
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="mo_ta" class="form-control" required>{{ $product->mo_ta }}</textarea>
        </div>

        <div class="mb-3">
    <label>Hình ảnh</label>
    <input type="file" name="hinh_anh" class="form-control">

    @if($product->hinh_anh)
        @php
            // Nếu DB lưu link http/https thì dùng trực tiếp
            // Nếu DB chỉ lưu tên file thì thêm asset('images/')
            $src = Str::startsWith($product->hinh_anh, ['http://','https://'])
                ? $product->hinh_anh
                : asset('images/'.$product->hinh_anh);
        @endphp

        <img src="{{ $src }}" 
             alt="{{ $product->ten_san_pham }}" 
             width="120" height="120" class="rounded mt-2">
    @endif  
</div>


        <div class="mb-3">
            <label>Giá bán</label>
            <input type="number" name="gia_ban" class="form-control" value="{{ $product->gia_ban }}" required>
        </div>

        <div class="mb-3">
            <label>Khuyến mãi (%)</label>
            <input type="number" name="km_phan_tram" class="form-control" value="{{ $product->km_phan_tram }}">
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="trang_thai" class="form-select">
                <option value="1" {{ $product->trang_thai ? 'selected' : '' }}>Đang bán</option>
                <option value="0" {{ !$product->trang_thai ? 'selected' : '' }}>Chưa bán</option>
            </select>
        </div>

        <button class="btn btn-success">Cập nhật</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
