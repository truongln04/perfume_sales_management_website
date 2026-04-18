@extends('layouts.admin')
@section('title','Thống kê & Báo cáo')
@section('header','Thống kê & Báo cáo')

@section('content')
<div class="row" style="min-height:100vh; background:#f8f9fa">
    {{-- Sidebar chọn loại thống kê --}}
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('admin.reports.doanhthu') }}" class="list-group-item list-group-item-action">
                📊 Doanh thu theo thời gian
            </a>
            <a href="{{ route('admin.reports.donhang') }}" class="list-group-item list-group-item-action">
                📦 Đơn hàng theo trạng thái
            </a>
            <a href="{{ route('admin.reports.tonkho') }}" class="list-group-item list-group-item-action">
                🏬 Xuất – Nhập – Tồn kho
            </a>
            <a href="{{ route('admin.reports.banchay') }}" class="list-group-item list-group-item-action">
                🔥 Sản phẩm bán chạy
            </a>
        </div>
    </div>

    {{-- Panel nội dung --}}
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <p>Chọn loại thống kê ở sidebar để xem báo cáo.</p>
            </div>
        </div>
    </div>
</div>
@endsection
