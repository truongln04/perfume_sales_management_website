@extends('layouts.client')
@section('title','Chi tiết đơn hàng')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-3">Chi tiết đơn hàng #{{ $order->id_don_hang }}</h3>

    <p><strong>Người nhận:</strong> {{ $order->ho_ten_nhan }}</p>
    <p><strong>SĐT:</strong> {{ $order->sdt_nhan }}</p>
    <p><strong>Địa chỉ:</strong> {{ $order->dia_chi_giao }}</p>
    <p><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($order->ngay_dat)->format('d/m/Y H:i') }}</p>
    <p>
                <strong>Trạng thái đơn hàng:</strong>
                <span class="badge bg-info">
                    {{ \App\Models\Order::statusLabels()[$order->trang_thai] ?? $order->trang_thai }}
                </span>
            </p>

            <p>
                <strong>Thanh toán:</strong>
                <span class="badge bg-success">
                    {{ \App\Models\Order::paymentStatusLabels()[$order->trang_thai_tt] ?? $order->trang_thai_tt }}
                </span>
            </p>



    <h5 class="mt-4">Sản phẩm trong đơn</h5>
    <table class="table table-sm">
        <thead>
            <tr>
                <th>Tên SP</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->details as $d)
                <tr>
                    <td>{{ $d->product->ten_san_pham }}</td>
                    <td>{{ $d->so_luong }}</td>
                    <td>{{ number_format($d->don_gia,0,',','.') }} ₫</td>
                    <td>{{ number_format($d->thanh_tien,0,',','.') }} ₫</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
