@extends('layouts.client')

@section('title','Kết quả thanh toán')

@section('content')
<div class="container py-5 text-center">

    {{-- Logo MoMo --}}
    <img src="https://developers.momo.vn/v3/vi/img/logo.svg"
         width="80"
         class="mb-3">

    <h3 class="fw-bold">Kết quả thanh toán MoMo</h3>

    @if($success)
        <div class="alert alert-success mt-4 shadow-sm" style="border-radius:12px">
            <h5 class="fw-bold mb-2">✔ Thanh toán thành công!</h5>

            @if(isset($order))
                <p>
                    Mã đơn hàng:
                    <strong>#{{ $order->id_don_hang }}</strong>
                </p>
            @endif

            <p class="mb-0">Cảm ơn bạn đã mua hàng tại PerfumeShop 💖</p>
        </div>

        <a href="{{ route('client.orderslist') }}"
           class="btn btn-success mt-3 px-4 rounded-pill">
            Xem đơn hàng
        </a>

        <a href="{{ route('client.home') }}"
           class="btn btn-outline-primary mt-3 px-4 rounded-pill">
            Về trang chủ
        </a>

    @else
        <div class="alert alert-danger mt-4 shadow-sm" style="border-radius:12px">
            <h5 class="fw-bold mb-2">❌ Thanh toán thất bại!</h5>

            <p>
                {{ $message ?? 'Bạn đã hủy thanh toán hoặc giao dịch bị từ chối' }}
            </p>
        </div>

        <a href="{{ route('client.cart') }}"
           class="btn btn-warning mt-3 px-4 rounded-pill">
            Quay lại giỏ hàng
        </a>
    @endif

</div>
@endsection