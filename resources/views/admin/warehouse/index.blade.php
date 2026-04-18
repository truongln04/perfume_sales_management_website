@extends('layouts.admin')
@section('title','Quản lý kho')
@section('header','Quản lý kho')

@section('content')
<div class="card mt-3">

    {{-- Header --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 text-primary fw-bold">Quản lý kho</h5>

        {{-- Ô tìm kiếm --}}
        <form method="GET" action="{{ route('warehouse.index') }}" class="d-flex gap-2">
            <input type="text"
                   name="keyword"
                   class="form-control"
                   placeholder="Tìm theo tên hoặc mã SP..."
                   value="{{ request('keyword') }}">
        </form>
    </div>

    {{-- Nội dung --}}
    <div class="card-body p-0">

        {{-- Cảnh báo tồn kho thấp --}}
        @php
            $lowStockWarnings = $items->filter(fn($item) => $item->ton_kho_hien_tai < 10);
        @endphp

        @if($lowStockWarnings->count() > 0)
            <div class="alert alert-danger m-2">
                <strong>Cảnh báo tồn kho thấp!</strong>
                <ul class="mt-2 mb-0">
                    @foreach($lowStockWarnings as $item)
                        <li>[ID: {{ $item->id_san_pham }}] {{ $item->product->ten_san_pham }} – còn 
                            <strong>{{ $item->ton_kho_hien_tai }}</strong> sản phẩm
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <table class="table table-hover table-striped m-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng nhập</th>
                    <th>Số lượng bán</th>
                    <th>Tồn kho hiện tại</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="{{ $item->ton_kho_hien_tai < 10 ? 'table-danger' : '' }}">
                        <td>{{ $item->id_san_pham }}</td>
                        <td>{{ $item->product->ten_san_pham }}</td>
                        <td>{{ $item->so_luong_nhap }}</td>
                        <td>{{ $item->so_luong_ban }}</td>
                        <td>{{ $item->ton_kho_hien_tai }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    <div class="card-footer">
        {{ $items->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
