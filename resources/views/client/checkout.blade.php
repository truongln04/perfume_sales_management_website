@extends('layouts.client')
@section('title','Thanh toán')

@section('content')
<div class="container py-5">
    <div class="row">

        {{-- Hiển thị thông báo --}}
        @if(session('success'))
            <div class="col-12 mb-4">
                <div class="alert alert-success alert-dismissible fade show text-center fw-medium" role="alert" style="border-radius:12px">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="col-12 mb-4">
                <div class="alert alert-danger alert-dismissible fade show text-center fw-medium" role="alert" style="border-radius:12px">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        {{-- BÊN TRÁI: Thông tin giao hàng --}}
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold mb-4">Thông tin giao hàng</h4>

                    <form action="{{ route('client.orders.checkout') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Họ và tên *</label>
                            <input type="text" name="hoTenNhan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Số điện thoại *</label>
                            <input type="text" name="sdtNhan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Địa chỉ giao hàng *</label>
                            <input type="text" name="diaChiGiao" class="form-control"
                                   placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ghi chú (tùy chọn)</label>
                            <textarea name="ghiChu" class="form-control" rows="3"></textarea>
                        </div>
                </div>
            </div>
        </div>

        {{-- BÊN PHẢI: Đơn hàng + Thanh toán --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold mb-4">Đơn hàng của bạn</h4>

                    @php
                        $cart = session('cart', []);
                        $totalPrice = collect($cart)->sum(fn($item) => $item['gia_ban'] * $item['quantity']);
                    @endphp

                    <table class="table table-borderless">
                        <thead class="text-muted border-bottom">
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-center">Giá</th>
                                <th class="text-center">SL</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $id => $item)
                                <tr>
                                    <td class="fw-medium">{{ $item['ten_san_pham'] }}</td>
                                    <td class="text-center">{{ number_format($item['gia_ban'],0,',','.') }} ₫</td>
                                    <td class="text-center">x{{ $item['quantity'] }}</td>
                                    <td class="text-end fw-bold">{{ number_format($item['gia_ban'] * $item['quantity'],0,',','.') }} ₫</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <h5 class="fw-bold">Tổng cộng</h5>
                        <h4 class="text-danger fw-bold">{{ number_format($totalPrice,0,',','.') }} ₫</h4>
                    </div>

                    <div class="mt-4 border-top pt-3">
                        <h5 class="mb-3">Phương thức thanh toán</h5>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="phuongThucTT" id="cod" value="COD" checked>
                            <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="phuongThucTT" id="online" value="ONLINE">
                            <label class="form-check-label d-flex align-items-center" for="online">
                                <img src="https://developers.momo.vn/v3/vi/img/logo.svg" alt="MoMo" style="width:40px;margin-right:10px">
                                <span>Thanh toán qua ví MoMo</span>
                            </label>
                        </div>
                    </div>

                    <button class="btn btn-warning btn-lg w-100 mt-4 fw-bold" style="border-radius:50px">
                        XÁC NHẬN ĐẶT HÀNG
                    </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
