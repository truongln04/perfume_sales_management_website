@extends('layouts.client')
@section('title','Sản phẩm')

@section('content')
    <h2 class="fw-bold mb-3">Danh sách sản phẩm</h2>

    <div class="row row-cols-1 row-cols-md-5 g-4">
        @foreach($products as $p)
            <div class="col">
                <x-product-card :product="$p" />
            </div>
        @endforeach
    </div>

    {{ $products->links('pagination::bootstrap-5') }}
@endsection
