@extends('layouts.client')
@section('title','Danh mục sản phẩm')

@section('content')
    <h2 class="fw-bold mb-3">Sản phẩm theo danh mục</h2>

    <div class="row">
        @forelse($products as $p)
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
        @empty
            <div class="col-12">
                <p class="text-muted">Không có sản phẩm nào trong danh mục này.</p>
            </div>
        @endforelse
    </div>

    {{-- Phân trang --}}
    {{ $products->links('pagination::bootstrap-5') }}
@endsection
