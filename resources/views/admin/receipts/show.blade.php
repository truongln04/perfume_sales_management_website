@extends('layouts.admin')
@section('title','Chi tiết phiếu nhập')
@section('header','Chi tiết phiếu nhập')

@section('content')
<div class="container-fluid">
    <p><strong>Ngày nhập:</strong> {{ \Carbon\Carbon::parse($receipt->ngay_nhap)->format('d/m/Y') }}</p>
    <p><strong>Nhà cung cấp:</strong> 
    {{ optional($receipt->receiptDetails->first()->product->supplier)->ten_ncc ?? 'Không xác định' }}
</p>


    <p><strong>Ghi chú:</strong> {{ $receipt->ghi_chu ?? 'Không có ghi chú' }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($receipt->tong_tien,0,',','.') }} đ</p>

    <h6>Chi tiết sản phẩm:</h6>
    <table class="table table-bordered">
        <thead><tr><th>Mã SP</th><th>Sản phẩm</th><th>Hình ảnh</th><th>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead>
       <tbody>
            @forelse($receipt->receiptDetails as $ct)
            <tr>
                <td>{{ $ct->product->id_san_pham ?? 'Không rõ' }}</td>
                <td>{{ $ct->product->ten_san_pham ?? 'Không rõ' }}</td>
                @php
    $src = $ct->product->hinh_anh && Str::startsWith($ct->product->hinh_anh, ['http://','https://'])
        ? $ct->product->hinh_anh
        : ($ct->product->hinh_anh ? asset('images/'.$ct->product->hinh_anh) : asset('images/default.jpg'));
@endphp

<td>
    <img src="{{ $src }}" alt="{{ $ct->product->ten_san_pham ?? 'Hình ảnh' }}" 
         width="60" height="60" class="rounded">
</td>

                <td>{{ $ct->so_luong }}</td>
                <td>{{ number_format($ct->don_gia,0,',','.') }} đ</td>
                <td>{{ number_format($ct->so_luong * $ct->don_gia,0,',','.') }} đ</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">Không có chi tiết</td></tr>
            @endforelse
        </tbody>

    </table>
</div>
@endsection
