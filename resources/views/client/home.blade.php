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
                <a href="{{ route('brand.show', $brand->id_thuong_hieu) }}">
                {{-- Nếu logo trong DB là http thì in trực tiếp, nếu là tên file thì dùng asset() --}}
                @if(Str::startsWith($brand->logo, ['http://','https://']))
                    <img src="{{ $brand->logo }}" alt="{{ $brand->ten_thuong_hieu }}" class="img-fluid">
                @else
                    <img src="{{ asset('images/'.$brand->logo) }}" alt="{{ $brand->ten_thuong_hieu }}" class="img-fluid">
                @endif
                </a>
            </div>
        @endforeach
    </div>

    {{-- Sản phẩm theo danh mục --}}
<div class="container py-5">

    @foreach($categories as $cat)
        @php
            $products = $productsByCategory[$cat->id_danh_muc] ?? [];
        @endphp

        {{-- Nếu danh mục có sản phẩm thì mới hiển thị --}}
        @if(count($products))
            <section class="mb-5">

                {{-- Header giống React --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold fs-3 text-dark">
                        {{ $cat->ten_danh_muc }}
                    </h2>

                    {{-- Xem thêm --}}
                    <span
                        style="cursor:pointer"
                        class="text-primary fw-medium fs-5"
                        onclick="window.location='{{ route('client.category', $cat->id_danh_muc) }}'">
                        Xem thêm ›
                    </span>
                </div>

                {{-- Grid sản phẩm --}}
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4 px-2">
                    @foreach($products as $p)
                        <div class="col">
                            <x-product-card :product="$p" />
                        </div>
                    @endforeach
                </div>

            </section>
        @endif
    @endforeach

</div>

@endsection
