@extends('layouts.admin')
@section('title','Doanh thu theo thời gian')
@section('header','Doanh thu theo thời gian')

@section('content')
<div class="container-fluid py-3">

    {{-- Thanh chọn loại thống kê --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label fw-bold">Loại thống kê</label>
            <select id="reportType" class="form-select">
                <option value="{{ route('admin.reports.doanhthu') }}" selected>Doanh thu theo thời gian</option>
                <option value="{{ route('admin.reports.donhang') }}">Đơn hàng theo trạng thái</option>
                <option value="{{ route('admin.reports.tonkho') }}">Xuất – Nhập – Tồn kho</option>
                <option value="{{ route('admin.reports.banchay') }}">Sản phẩm bán chạy</option>
            </select>
        </div>
    </div>

    {{-- Bộ lọc --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.doanhthu') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" name="fromDate" class="form-control" value="{{ request('fromDate') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" name="toDate" class="form-control" value="{{ request('toDate') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Phương thức thanh toán</label>
                    <select name="payment" class="form-select">
                        <option value="">-- Tất cả --</option>
                        <option value="COD" {{ request('payment')=='COD'?'selected':'' }}>COD</option>
                        <option value="Online" {{ request('payment')=='Online'?'selected':'' }}>Online</option>
                    </select>
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
            <h5 class="fw-bold mb-3">📊 Doanh thu theo thời gian</h5>
            @if($data->isEmpty())
                <div class="alert alert-warning">Không có dữ liệu</div>
            @else
                <canvas id="doanhThuChart" style="max-height:350px; width:100%;"></canvas>
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
    const ctx = document.getElementById('doanhThuChart');
    if(ctx){
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($data->pluck('ngay')) !!},
                datasets: [{
                    label:'Doanh thu',
                    data:{!! json_encode($data->pluck('doanhThu')) !!},
                    borderColor:'#0d6efd',
                    backgroundColor:'rgba(13,110,253,0.2)',
                    fill:true,
                    tension:0.3 // đường cong mượt hơn
                }]
            },
            options: {
                responsive:true,
                maintainAspectRatio:false, // cho phép kiểm soát tỷ lệ
                aspectRatio:2,             // tỷ lệ rộng/cao để biểu đồ gọn lại
                plugins:{ legend:{ position:'top' } },
                scales:{
                    y:{ beginAtZero:true }
                }
            }
        });
    }
});
</script>
@endsection
