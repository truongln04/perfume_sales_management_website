@extends('layouts.client')
@section('title','Chi tiết đơn hàng')

@section('content')
<div class="container py-4">

    @php
        $statusTabs = [
            'CHO_XAC_NHAN' => ['label'=>'Chờ xác nhận','color'=>'warning'],
            'DA_XAC_NHAN' => ['label'=>'Đã xác nhận','color'=>'info'],
            'DANG_GIAO' => ['label'=>'Đang giao','color'=>'primary'],
            'HOAN_THANH' => ['label'=>'Hoàn thành','color'=>'success'],
            'TRA_HANG' => ['label'=>'Trả hàng','color'=>'dark'],
            'HUY' => ['label'=>'Hủy','color'=>'danger'],
        ];

        $statusLabels = \App\Models\Order::statusLabels();
        $paymentLabels = \App\Models\Order::paymentStatusLabels();

        $tab = $statusTabs[$order->trang_thai] ?? ['color' => 'secondary'];
    @endphp

    <h3 class="fw-bold mb-3">
        Chi tiết đơn hàng #{{ $order->id_don_hang }}
    </h3>

    <p><strong>Người nhận:</strong> {{ $order->ho_ten_nhan }}</p>
    <p><strong>SĐT:</strong> {{ $order->sdt_nhan }}</p>
    <p><strong>Địa chỉ:</strong> {{ $order->dia_chi_giao }}</p>

    <p>
        <strong>Ngày đặt:</strong>
        {{ \Carbon\Carbon::parse($order->ngay_dat)->format('d/m/Y H:i') }}
    </p>

    {{-- ✅ Trạng thái đơn hàng --}}
    <p>
        <strong>Trạng thái đơn hàng:</strong>
        <span class="badge bg-{{ $tab['color'] }}">
            {{ $statusLabels[$order->trang_thai] ?? $order->trang_thai }}
        </span>
    </p>

    {{-- ✅ Trạng thái thanh toán --}}
    <p>
        <strong>Trạng Thái Thanh toán:</strong>
        <span class="badge 
            {{ $order->trang_thai_tt == 'DA_THANH_TOAN' ? 'bg-success' : 'bg-warning' }}">
            {{ $paymentLabels[$order->trang_thai_tt] ?? $order->trang_thai_tt }}
        </span>
    </p>

    {{-- Danh sách sản phẩm --}}
    <h5 class="mt-4">Sản phẩm trong đơn</h5>

    <table class="table table-sm table-hover align-middle">
        <thead class="table-light">
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
                    <td>
                        {{ number_format($d->thanh_tien,0,',','.') }} ₫
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection