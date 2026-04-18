@extends('layouts.admin')
@section('title','Đơn hàng theo trạng thái')
@section('header','Đơn hàng theo trạng thái')

@section('content')
<div class="container-fluid py-3">

    {{-- Thanh chọn loại thống kê --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label fw-bold">Loại thống kê</label>
            <select id="reportType" class="form-select">
                <option value="{{ route('admin.reports.doanhthu') }}">Doanh thu theo thời gian</option>
                <option value="{{ route('admin.reports.donhang') }}" selected>Đơn hàng theo trạng thái</option>
                <option value="{{ route('admin.reports.tonkho') }}">Xuất – Nhập – Tồn kho</option>
                <option value="{{ route('admin.reports.banchay') }}">Sản phẩm bán chạy</option>
            </select>
        </div>
    </div>

    {{-- Bộ lọc --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.donhang') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" name="fromDate" class="form-control" value="{{ request('fromDate') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" name="toDate" class="form-control" value="{{ request('toDate') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Trạng thái đơn hàng</label>
                    <select name="orderStatus" class="form-select">
                        <option value="">-- Tất cả --</option>
                        <option value="Chờ xử lý" {{ request('orderStatus')=='Chờ xử lý'?'selected':'' }}>Chờ xử lý</option>
                        <option value="Đang giao" {{ request('orderStatus')=='Đang giao'?'selected':'' }}>Đang giao</option>
                        <option value="Hoàn thành" {{ request('orderStatus')=='Hoàn thành'?'selected':'' }}>Hoàn thành</option>
                        <option value="Hủy" {{ request('orderStatus')=='Hủy'?'selected':'' }}>Hủy</option>
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
            <h5 class="fw-bold mb-3">📊 Đơn hàng theo trạng thái</h5>
            @if($data->isEmpty())
                <div class="alert alert-warning">Không có dữ liệu</div>
            @else
                <canvas id="donHangChart" style="max-height:300px; width:100%;"></canvas>
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
    const ctx = document.getElementById('donHangChart');
    if(ctx){
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($data->pluck('trang_thai')) !!},
                datasets: [{
                    data:{!! json_encode($data->pluck('soLuong')) !!},
                    backgroundColor:['#0d6efd','#198754','#ffc107','#dc3545','#6f42c1']
                }]
            },
            options:{
                responsive:true,
                maintainAspectRatio:false, // cho phép chỉnh tỷ lệ
                aspectRatio:1.5,           // tỷ lệ rộng/cao để biểu đồ gọn lại
                plugins:{
                    legend:{ position:'right' }
                }
            }
        });
    }
});
</script>
@endsection
