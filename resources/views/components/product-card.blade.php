@props(['product'])

<a href="{{ route('client.product',$product->id_san_pham) }}"
   class="card h-100 text-center text-decoration-none text-dark position-relative shadow-sm"
   style="opacity:0.95; transform:scale(0.95); transition:all 0.3s ease;">
    
    {{-- Ảnh + badge --}}
    <div class="bg-white overflow-hidden position-relative d-flex align-items-center justify-content-center" style="height:220px; padding:10px;">
        @if($product->km_phan_tram > 0)
            <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="z-index:2">
                -{{ (int)$product->km_phan_tram }}%
            </span>
        @endif

        @if(Str::startsWith($product->hinh_anh,['http://','https://']))
            <img src="{{ $product->hinh_anh }}" alt="{{ $product->ten_san_pham }}"
                 class="img-fluid" style="max-height:100%; width:auto; object-fit:contain; z-index:1">
        @else
            <img src="{{ asset('images/'.$product->hinh_anh) }}" alt="{{ $product->ten_san_pham }}"
                 class="img-fluid" style="max-height:100%; width:auto; object-fit:contain; z-index:1">
        @endif
    </div>

    {{-- Thông tin --}}
    <div class="card-body p-2">
        <p class="text-muted small mb-1 fw-medium text-uppercase">
            {{ $product->brand->ten_thuong_hieu ?? 'ORCHARD' }}
        </p>
        <h6 class="fw-bold mb-2" style="font-size:0.9rem">
            {{ $product->ten_san_pham }}
        </h6>

        <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
            <span class="text-danger fw-bold fs-6">
                {{ number_format(
                    $product->km_phan_tram > 0
                        ? round($product->gia_ban * (1 - $product->km_phan_tram/100))
                        : $product->gia_ban, 0, ',', '.'
                ) }} ₫
            </span>
            @if($product->km_phan_tram > 0)
                <span class="text-muted small text-decoration-line-through">
                    {{ number_format($product->gia_ban,0,',','.') }} ₫
                </span>
            @endif
        </div>
    </div>
</a>
