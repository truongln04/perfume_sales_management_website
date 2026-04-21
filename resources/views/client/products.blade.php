@extends('layouts.client')
@section('title','Sản phẩm')

@section('content')
    <h2 class="fw-bold mb-3">Danh sách sản phẩm</h2>
    <div class="row">
        @foreach($products as $p)
            <div class="col-md-3 mb-5">
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
    {{ $products->links('pagination::bootstrap-5') }}
@endsection
