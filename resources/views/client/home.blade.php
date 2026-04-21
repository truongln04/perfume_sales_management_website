@extends('layouts.client')
@section('title','Trang chủ')

@section('content')
    {{-- Banner --}}
    <div class="banner mb-4">
        <img src="https://orchard.vn/wp-content/uploads/2026/02/don-ma-khoi-sac-mo-loi-len-huong2.webp"
             alt="Banner" class="img-fluid rounded shadow">
    </div>

    {{-- Thương hiệu nổi bật --}}
    <h2 class="fw-bold mb-3">Thương hiệu nổi bật</h2>
    <div class="row text-center mb-5">
        @foreach($brands as $brand)
            <div class="col">
                {{-- Nếu logo trong DB là http thì in trực tiếp, nếu là tên file thì dùng asset() --}}
                @if(Str::startsWith($brand->logo, ['http://','https://']))
                    <img src="{{ $brand->logo }}" alt="{{ $brand->ten_thuong_hieu }}" class="img-fluid">
                @else
                    <img src="{{ asset('images/'.$brand->logo) }}" alt="{{ $brand->ten_thuong_hieu }}" class="img-fluid">
                @endif
            </div>
        @endforeach
    </div>

    {{-- Sản phẩm mới --}}
    <h2 class="fw-bold mb-3">Sản phẩm mới</h2>
    <div class="row row-cols-1 row-cols-md-5 g-4">
    @foreach($products as $p)
        <div class="col">
            <x-product-card :product="$p" />
        </div>
    @endforeach
</div>

@endsection
