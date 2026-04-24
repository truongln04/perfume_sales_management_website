@extends('layouts.client')
@section('title','Thanh toán')

@section('content')
<div class="container py-5">
    <div class="row">

        {{-- ALERT --}}
        @if(session('success'))
            <div class="col-12 mb-4">
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="col-12 mb-4">
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('client.orders.checkout') }}" method="POST">
            @csrf

            {{-- LEFT --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Thông tin giao hàng</h4>

                        <div class="mb-3">
                            <label>Họ và tên *</label>
                            <input type="text" name="hoTenNhan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Số điện thoại *</label>
                            <input type="text" name="sdtNhan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Địa chỉ *</label>
                            <input type="text" name="diaChiGiao" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Ghi chú</label>
                            <textarea name="ghiChu" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Đơn hàng</h4>

                        @php
                            $cart = session('cart', []);
                            $totalPrice = collect($cart)->sum(fn($item) => $item['gia_ban'] * $item['quantity']);
                        @endphp

                        <table class="table">
                            @foreach($cart as $item)
                                <tr>
                                    <td>{{ $item['ten_san_pham'] }}</td>
                                    <td>x{{ $item['quantity'] }}</td>
                                    <td class="text-end">
                                        {{ number_format($item['gia_ban'] * $item['quantity']) }} ₫
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <strong>Tổng:</strong>
                            <strong class="text-danger">
                                {{ number_format($totalPrice) }} ₫
                            </strong>
                        </div>

                        {{-- PAYMENT --}}
                        <div class="mt-4">
                            <h5>Thanh toán</h5>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="phuongThucTT"
                                       value="COD"
                                       checked>
                                <label class="form-check-label">
                                    COD
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="phuongThucTT"
                                       value="ONLINE">
                                <label class="form-check-label">
                                    <img src="https://developers.momo.vn/v3/vi/img/logo.svg" width="40">
                                    MoMo
                                </label>
                            </div>
                        </div>

                        <button class="btn btn-warning w-100 mt-4 fw-bold">
                            ĐẶT HÀNG
                        </button>

                    </div>
                </div>
            </div>

        </form>

    </div>
</div>
@endsection