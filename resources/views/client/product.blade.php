@extends('layouts.client')
@section('title',$product->ten_san_pham)

@section('content')
<div class="container py-5">

    {{-- Chi tiết sản phẩm --}}
    <div class="row g-5 mb-5">
        <div class="col-md-5">
            <div class="border rounded shadow-sm p-3 bg-white text-center position-relative">
                {{-- Nếu ảnh là URL http thì in trực tiếp, nếu là tên file thì dùng asset --}}
                @if(Str::startsWith($product->hinh_anh, ['http://','https://']))
                    <img src="{{ $product->hinh_anh }}" alt="{{ $product->ten_san_pham }}"
                         class="img-fluid" style="max-height:350px; object-fit:contain">
                @else
                    <img src="{{ asset('images/'.$product->hinh_anh) }}" alt="{{ $product->ten_san_pham }}"
                         class="img-fluid" style="max-height:350px; object-fit:contain">
                @endif

                @if($product->km_phan_tram > 0)
                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                        -{{ $product->km_phan_tram }}%
                    </span>
                @endif
            </div>
        </div>

        <div class="col-md-7">
            <h3 class="fw-bold mb-3">{{ $product->ten_san_pham }}</h3>
            <p><strong>Loại:</strong> {{ $product->category->ten_danh_muc ?? '—' }}</p>
            <p><strong>Thương hiệu:</strong> {{ $product->brand->ten_thuong_hieu ?? 'ORCHARD' }}</p>

            <p><strong>Tồn kho:</strong> {{ $product->so_luong_ton ?? 0 }} sản phẩm</p>

            <div class="mb-4">
                <span class="text-danger fw-bold fs-4">
                    {{ number_format(
                        $product->km_phan_tram > 0
                            ? round($product->gia_ban * (1 - $product->km_phan_tram/100))
                            : $product->gia_ban, 0, ',', '.'
                    ) }} ₫
                </span>
                @if($product->km_phan_tram > 0)
                    <span class="text-muted ms-3 text-decoration-line-through">
                        {{ number_format($product->gia_ban,0,',','.') }} ₫
                    </span>
                @endif
            </div>

            <form method="POST" action="{{ route('client.cart.add',$product->id_san_pham) }}" class="d-flex align-items-center gap-3 mb-4">
                @csrf
                <label>Số lượng:</label>
                <input type="number" name="quantity" min="1" value="1" class="form-control w-25">
                <button type="submit"
                        class="btn btn-primary btn-lg fw-bold rounded-pill shadow-sm flex-grow-1">
                    🛒 Thêm vào giỏ hàng
                </button>
            </form>
        </div>
    </div>

    {{-- Mô tả --}}
    <div class="row mb-5">
        <div class="col-12">
            <h5 class="fw-bold mb-3">Mô tả</h5>
            <div class="border rounded p-3 bg-light" style="min-height:200px; white-space:pre-line">
                {{ $product->mo_ta ?? 'Chưa có mô tả cho sản phẩm này.' }}
            </div>
        </div>
    </div>

{{-- Sản phẩm liên quan --}}
{{-- Sản phẩm liên quan --}}
<div class="row">
    <h5 class="fw-bold mb-3">Sản phẩm liên quan</h5>
    <div class="row row-cols-1 row-cols-md-5 g-4">
        @forelse($related as $p)
            <div class="col">
                <x-product-card :product="$p" />
            </div>
        @empty
            <p class="text-muted">Chưa có sản phẩm liên quan.</p>
        @endforelse
    </div>
</div>

</div>
@endsection
