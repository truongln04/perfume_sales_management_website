@extends('layouts.admin')
@section('content')
<div class="card">
 <div class="card-header"><h5>Cập nhật đơn hàng #{{ $order->id_don_hang }}</h5></div>
 <div class="card-body">
  <form method="POST" action="{{ route('admin.orders.update', $order) }}">
   @csrf @method('PUT')

   {{-- Trạng thái đơn hàng --}}
   <div class="mb-3">
     <label>Trạng thái đơn hàng</label>
     @if(in_array($order->trang_thai, ['HUY','TRA_HANG']))
       <span class="badge {{ $order->trang_thai=='HUY'?'bg-secondary':'bg-danger' }}">
         {{ \App\Models\Order::statusLabels()[$order->trang_thai] }}
       </span>
     @else
       <select name="trang_thai" class="form-select">
         @if($order->trang_thai=='CHO_XAC_NHAN')
           <option value="CHO_XAC_NHAN">Chờ xác nhận</option>
           <option value="DA_XAC_NHAN">Đã xác nhận</option>
           <option value="HUY">Hủy đơn</option>
         @elseif($order->trang_thai=='DA_XAC_NHAN')
           <option value="DA_XAC_NHAN">Đã xác nhận</option>
           <option value="DANG_GIAO">Đang giao</option>
           <option value="HUY">Hủy đơn</option>
         @elseif($order->trang_thai=='DANG_GIAO')
           <option value="DANG_GIAO">Đang giao</option>
           <option value="HOAN_THANH">Hoàn thành</option>
           <option value="HUY">Hủy đơn</option>
         @elseif($order->trang_thai=='HOAN_THANH')
           <option value="HOAN_THANH">Hoàn thành</option>
           <option value="TRA_HANG">Trả hàng</option>
         @endif
       </select>
     @endif
   </div>

   {{-- Trạng thái thanh toán --}}
   <div class="mb-3">
     <label>Trạng thái thanh toán</label>
     @if($order->trang_thai=='HUY' && $order->phuong_thuc_tt=='COD')
       <span class="badge bg-secondary">Chưa TT</span>
     @elseif($order->trang_thai=='HUY' && $order->phuong_thuc_tt=='ONLINE')
       @if(in_array($order->trang_thai_tt,['HOAN_TIEN','DA_HOAN_TIEN']))
         <span class="badge bg-danger">
           {{ \App\Models\Order::paymentStatusLabels()[$order->trang_thai_tt] }}
         </span>
       @else
         <select name="trang_thai_tt" class="form-select border-danger text-danger">
           <option value="HOAN_TIEN" {{ $order->trang_thai_tt=='HOAN_TIEN'?'selected':'' }}>Hoàn tiền</option>
           <option value="DA_HOAN_TIEN" {{ $order->trang_thai_tt=='DA_HOAN_TIEN'?'selected':'' }}>Đã hoàn tiền</option>
         </select>
       @endif
     @else
       {{-- Các trạng thái khác --}}
       @if($order->trang_thai_tt=='CHUA_THANH_TOAN')
         <select name="trang_thai_tt" class="form-select border-warning text-warning">
           <option value="CHUA_THANH_TOAN" selected>Chưa TT</option>
           <option value="DA_THANH_TOAN">Đã TT</option>
           <option value="HOAN_TIEN">Hoàn tiền</option>
         </select>
       @elseif($order->trang_thai_tt=='DA_THANH_TOAN')
         <select name="trang_thai_tt" class="form-select border-success text-success">
           <option value="DA_THANH_TOAN" selected>Đã TT</option>
           <option value="HOAN_TIEN">Hoàn tiền</option>
         </select>
       @elseif($order->trang_thai_tt=='HOAN_TIEN')
         <select name="trang_thai_tt" class="form-select border-danger text-danger">
           <option value="HOAN_TIEN" selected>Hoàn tiền</option>
           <option value="DA_HOAN_TIEN">Đã hoàn tiền</option>
         </select>
       @else
         <span class="badge bg-danger">Đã hoàn tiền</span>
       @endif
     @endif
   </div>

   <button class="btn btn-primary">Lưu thay đổi</button>
   <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Hủy</a>
  </form>
 </div>
</div>
@endsection
