@extends('layouts.admin')
@section('content')
<div class="card">
 <div class="card-header"><h5>Chi tiết đơn hàng #{{ $order->id_don_hang }}</h5></div>
 <div class="card-body">
   <p><strong>Người nhận:</strong> {{ $order->ho_ten_nhan }}</p>
   <p><strong>SĐT:</strong> {{ $order->sdt_nhan }}</p>
   <p><strong>Địa chỉ:</strong> {{ $order->dia_chi_giao }}</p>
   <p><strong>Ghi chú:</strong> {{ $order->ghi_chu }}</p>
   <p><strong>TT Thanh toán:</strong> {{ \App\Models\Order::paymentStatusLabels()[$order->trang_thai_tt] ?? $order->trang_thai_tt }}</p>
   <p><strong>Trạng thái:</strong> {{ \App\Models\Order::statusLabels()[$order->trang_thai] ?? $order->trang_thai }}</p>
   <table class="table table-bordered mt-3">
    <thead><tr><th>Tên SP</th><th>SL</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead>
    <tbody>
      @foreach($order->chiTietDonHang as $d)
      <tr>
        <td>{{ $d->sanPham->ten_san_pham ?? '' }}</td>
        <td>{{ $d->so_luong }}</td>
        <td>{{ number_format($d->don_gia) }} đ</td>
        <td>{{ number_format($d->thanh_tien) }} đ</td>
      </tr>
      @endforeach
    </tbody>
   </table>
   <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại</a>
 </div>
</div>
@endsection