@extends('layouts.client')
@section('title', $brand->ten_thuong_hieu)

@section('content')
<div class="container py-4">

    {{-- Tiêu đề + breadcrumb --}}
   <nav class="mb-4">
        <h4 class="fw-bold mb-4 text-dark">Nước hoa
        {{ $brand->ten_thuong_hieu ?? 'Thương hiệu' }}
    </h4>
        <ol class="breadcrumb">
             <li class="breadcrumb-item" 
            style="cursor:pointer;" 
            onclick="window.location='{{ url('/') }}'">
                Trang chủ
            </li>
            <li class="breadcrumb-item" 
            style="cursor:pointer;" 
            onclick="window.location='{{ url('/products') }}'">
                Nước hoa
            </li>
            <li class="breadcrumb-item active"> Nước hoa
                {{ $brand->ten_thuong_hieu ?? '' }}
            </li>
        </ol>
    </nav>

    {{-- Filter giá --}}
    <div class="d-flex align-items-center gap-2 mb-4 flex-wrap">
        <span class="text-muted small">Lọc theo giá:</span>

        @php $price = request('price', 'all'); @endphp

        <a href="?price=all"
           class="btn btn-sm rounded-pill px-3 {{ $price=='all' ? 'btn-dark' : 'btn-outline-secondary' }}">
            Tất cả
        </a>

        <a href="?price=0-2000000"
           class="btn btn-sm rounded-pill px-3 {{ $price=='0-2000000' ? 'btn-dark' : 'btn-outline-secondary' }}">
            Dưới 2 triệu
        </a>

        <a href="?price=2000000-4000000"
           class="btn btn-sm rounded-pill px-3 {{ $price=='2000000-4000000' ? 'btn-dark' : 'btn-outline-secondary' }}">
            2 - 4 triệu
        </a>

        <a href="?price=4000000-999999999"
           class="btn btn-sm rounded-pill px-3 {{ $price=='4000000-999999999' ? 'btn-dark' : 'btn-outline-secondary' }}">
            Trên 4 triệu
        </a>
    </div>

    {{-- Danh sách sản phẩm --}}
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
        @forelse($products as $p)
            <div class="col">
                <x-product-card :product="$p" />
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                Không có sản phẩm nào
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>

</div>
@endsection