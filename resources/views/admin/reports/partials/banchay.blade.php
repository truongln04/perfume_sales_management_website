@extends('layouts.admin')
@section('title','Sản phẩm bán chạy')
@section('header','Sản phẩm bán chạy')

@section('content')
<div class="container-fluid py-3">

    {{-- Thanh chọn loại thống kê --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label fw-bold">Loại thống kê</label>
            <select id="reportType" class="form-select">
                <option value="{{ route('admin.reports.doanhthu') }}">Doanh thu theo thời gian</option>
                <option value="{{ route('admin.reports.donhang') }}">Đơn hàng theo trạng thái</option>
                <option value="{{ route('admin.reports.tonkho') }}">Xuất – Nhập – Tồn kho</option>
                <option value="{{ route('admin.reports.banchay') }}" selected>Sản phẩm bán chạy</option>
            </select>
        </div>
    </div>

    {{-- Bộ lọc --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.banchay') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" name="fromDate" class="form-control" value="{{ request('fromDate') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" name="toDate" class="form-control" value="{{ request('toDate') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Top sản phẩm</label>
                    <input type="number" name="top" class="form-control" value="{{ request('top',10) }}" min="1">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Chart --}}
    <div class="card">
        <div class="card-body">
            <h5 class="fw-bold mb-3">📊 Sản phẩm bán chạy</h5>
            @if($data->isEmpty())
                <div class="alert alert-warning">Không có dữ liệu</div>
            @else
                <canvas id="banChayChart" style="max-height:400px; width:100%;"></canvas>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Điều hướng khi đổi loại thống kê
    const select = document.getElementById('reportType');
    select.addEventListener('change', e => {
        window.location.href = e.target.value;
    });

    // Chart
    const ctx = document.getElementById('banChayChart');
    if(ctx){
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data->pluck('ten_san_pham')) !!},
                datasets: [{
                    label:'Tổng bán',
                    data:{!! json_encode($data->pluck('tongBan')) !!},
                    backgroundColor:'rgba(13,110,253,0.7)'
                }]
            },
            options:{
                indexAxis:'y',
                responsive:true,
                maintainAspectRatio:false, // cho phép kiểm soát tỷ lệ
                aspectRatio:2,             // tỷ lệ rộng/cao để biểu đồ gọn lại
                plugins:{ legend:{ display:false } },
                scales:{
                    x:{ beginAtZero:true }
                }
            }
        });
    }
});
</script>
@endsection
