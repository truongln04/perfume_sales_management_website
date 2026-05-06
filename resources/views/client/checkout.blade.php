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

        <form action="{{ route('client.orders.checkout') }}" method="POST" class="row">
            @csrf

            {{-- ✅ GIỮ DANH SÁCH ĐÃ CHỌN --}}
            @foreach($selectedIds as $id)
                <input type="hidden" name="selected[]" value="{{ $id }}">
            @endforeach

            {{-- LEFT --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Thông tin giao hàng</h4>

                        <div class="mb-3">
                            <label>Họ và tên *</label>
                            <input type="text" name="hoTenNhan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>SĐT *</label>
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
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Đơn hàng</h4>

                        @php $totalPrice = 0; @endphp

                        <table class="table">
                            @forelse($cartItems as $item)

                                @php
                                    $thanhTien = $item->don_gia * $item->so_luong;
                                    $totalPrice += $thanhTien;
                                @endphp

                                <tr>
                                    <td>{{ $item->product->ten_san_pham }}</td>
                                    <td>x{{ $item->so_luong }}</td>
                                    <td class="text-end">
                                        {{ number_format($thanhTien,0,',','.') }} ₫
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Không có sản phẩm
                                    </td>
                                </tr>
                            @endforelse
                        </table>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <strong>Tổng:</strong>
                            <strong class="text-danger">
                                {{ number_format($totalPrice,0,',','.') }} ₫
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
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="phuongThucTT"
                                       value="ONLINE">
                                <label class="form-check-label">
                                    <img src="https://developers.momo.vn/v3/vi/img/logo.svg" width="40">
                                    Thanh toán MoMo
                                </label>
                            </div>
                        </div>

                        <button class="btn btn-warning w-100 mt-4 fw-bold">
                            🛒 ĐẶT HÀNG
                        </button>

                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection