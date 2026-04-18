@extends('layouts.client')
@section('title',$product->ten_san_pham)

@section('content')
    <div class="row">
        <div class="col-md-5">
            <img src="{{ asset('images/'.$product->hinh_anh) }}" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-7">
            <h2>{{ $product->ten_san_pham }}</h2>
            <p class="text-danger fw-bold">{{ number_format($product->gia_ban,0,',','.') }} đ</p>
            <p>{{ $product->mo_ta }}</p>
            <button class="btn btn-primary">Thêm vào giỏ</button>
        </div>
    </div>
@endsection
