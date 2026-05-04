@extends('layouts.client')
@section('title','Danh mục sản phẩm')

@section('content')
<div class="container py-5">

    {{-- Tiêu đề + Breadcrumb --}}
    <nav class="mb-4">
        <h4 class="fw-bold mb-4 text-dark">
        {{ $category->ten_danh_muc ?? 'Danh mục' }}
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
            <li class="breadcrumb-item active">
                {{ $category->ten_danh_muc ?? '' }}
            </li>
        </ol>
    </nav>

    {{-- Bộ lọc giá --}}
    @php
        $priceFilter = request('price', 'all');
    @endphp

    <div class="d-flex flex-wrap align-items-center gap-3 mb-5">
        <span class="text-muted fw-medium me-2" style="font-size:0.95rem;">
            Lọc theo giá:
        </span>

        @php
            $filters = [
                'all' => 'Tất cả',
                '0-2000000' => 'Dưới 2 triệu',
                '2000000-4000000' => '2 - 4 triệu',
                '4000001-999999999' => 'Trên 4 triệu'
            ];
        @endphp

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
            <div class="col-12 text-center py-5 text-muted">
                Không có sản phẩm nào.
            </div>
        @endforelse
    </div>

    {{-- Phân trang --}}
    <div class="mt-4">
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection