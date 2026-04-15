@extends('layouts.admin')
@section('title','Quản lý kho')
@section('header','Quản lý kho')

@section('content')
<div class="container-fluid">

    {{-- Cảnh báo tồn kho thấp --}}
    @php
        $lowStockWarnings = $items->filter(fn($item) => $item->ton_kho_hien_tai < 10);
    @endphp

    @if($lowStockWarnings->count() > 0)
    <div class="alert alert-danger d-flex align-items-start gap-3 mb-4 p-3" role="alert"
         style="border-left:6px solid #b30000; background:#ffe6e6">
        {{-- Icon cảnh báo --}}
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor"
             class="text-danger" viewBox="0 0 16 16">
            <path d="M7.938 2.016A1.5 1.5 0 0 1 9.44 3.1l6.293 10.9c.55.953-.066 2.1-1.22 2.1H1.487c-1.154 0-1.77-1.147-1.22-2.1L6.56 3.1a1.5 1.5 0 0 1 1.379-.884zM8 5a.905.905 0 0 0-.9.9v3.6a.9.9 0 1 0 1.8 0V5.9A.905.905 0 0 0 8 5zm0 8a1.05 1.05 0 1 0 0-2.1 1.05 1.05 0 0 0 0 2.1z"/>
        </svg>

        <div>
            <strong class="text-danger fs-6">Cảnh báo tồn kho thấp!</strong>
            <p class="m-0 mt-1 text-danger">
                Có <strong>{{ $lowStockWarnings->count() }}</strong> sản phẩm dưới mức tồn kho cho phép:
            </p>
            <ul class="mt-2 mb-0">
    @foreach($lowStockWarnings as $item)
        <li class="text-danger">
            [ID: {{ $item->id_san_pham }}] {{ $item->product->ten_san_pham }} – còn 
            <strong>{{ $item->ton_kho_hien_tai }}</strong> sản phẩm
        </li>
    @endforeach
</ul>

        </div>
    </div>
    @endif

    {{-- Bảng danh sách tồn kho --}}
    <h5>Danh sách tồn kho</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sản phẩm</th>
                <th>Số lượng nhập</th>
                <th>Số lượng bán</th>
                <th>Tồn kho hiện tại</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr class="{{ $item->ton_kho_hien_tai < 10 ? 'table-danger' : '' }}">
                <td>{{ $item->id_san_pham }}</td>
                <td>{{ $item->product->ten_san_pham }}</td>
                <td>{{ $item->so_luong_nhap }}</td>
                <td>{{ $item->so_luong_ban }}</td>
                <td>{{ $item->ton_kho_hien_tai }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
