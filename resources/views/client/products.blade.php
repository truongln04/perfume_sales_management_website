@extends('layouts.client')
@section('title','Sản phẩm')

@section('content')
<div class="container py-4 my-4">

    {{-- Tiêu đề --}}
    <h4 class="fw-bold mb-3">Nước hoa</h4>

    {{-- Breadcrumb (không hiện link nhưng vẫn click được) --}}
    <nav class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"
                style="cursor:pointer"
                onclick="window.location='{{ url('/') }}'">
                Trang chủ
            </li>
            <li class="breadcrumb-item" 
            style="cursor:pointer;" 
            onclick="window.location='{{ url('/products') }}'">
                Nước hoa
            </li>
        </ol>
    </nav>

    {{-- Lọc giá --}}
    @php
        $priceFilter = request('price', 'all');

        $filters = [
            'all' => 'Tất cả',
            '0-2000000' => 'Dưới 2 triệu',
            '2000000-4000000' => '2 - 4 triệu',
            '4000001-999999999' => 'Trên 4 triệu'
        ];
    @endphp

    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
        <span class="text-muted fw-medium me-2" style="font-size:0.95rem;">
            Lọc theo giá:
        </span>

        @foreach($filters as $key => $label)
            <a href="{{ request()->fullUrlWithQuery(['price' => $key]) }}"
               class="btn btn-sm rounded-pill px-4
               {{ $priceFilter == $key ? 'btn-dark' : 'btn-outline-secondary' }}"
               style="font-size:0.875rem;">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Grid sản phẩm --}}
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
        @forelse($products as $p)
            <div class="col">
                <x-product-card :product="$p" />
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                Không có sản phẩm nào.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection