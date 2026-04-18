@extends('layouts.client')
@section('title','Trang chủ')

@section('content')
    {{-- Banner --}}
    <div class="banner mb-4">
        <img src="/images/banner.jpg" alt="Banner" class="img-fluid rounded shadow">
    </div>

    {{-- Thương hiệu nổi bật --}}
    <h2 class="fw-bold mb-3">Thương hiệu nổi bật</h2>
    <div class="row text-center mb-5">
        <div class="col"><img src="/images/brands/dior.png" alt="DIOR" class="img-fluid"></div>
        <div class="col"><img src="/images/brands/chanel.png" alt="CHANEL" class="img-fluid"></div>
        <div class="col"><img src="/images/brands/gucci.png" alt="GUCCI" class="img-fluid"></div>
        <div class="col"><img src="/images/brands/ysl.png" alt="YSL" class="img-fluid"></div>
    </div>

    {{-- Sản phẩm mới --}}
    <h2 class="fw-bold mb-3">Sản phẩm mới</h2>
    <div class="row">
        @foreach($products as $p)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/'.$p->hinh_anh) }}" class="card-img-top" alt="{{ $p->ten_san_pham }}">
                    <div class="card-body">
                        <h6 class="card-title">{{ $p->ten_san_pham }}</h6>
                        <p class="text-danger fw-bold">{{ number_format($p->gia_ban,0,',','.') }} đ</p>
                        <a href="{{ route('client.product',$p->id_san_pham) }}" class="btn btn-sm btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
