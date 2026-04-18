@extends('layouts.admin')
@section('title','Xuất – Nhập – Tồn kho')
@section('header','Xuất – Nhập – Tồn kho')

@section('content')
<div class="container-fluid py-3">

    {{-- Thanh chọn loại thống kê --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label fw-bold">Loại thống kê</label>
            <select id="reportType" class="form-select">
                <option value="{{ route('admin.reports.doanhthu') }}">Doanh thu theo thời gian</option>
                <option value="{{ route('admin.reports.donhang') }}">Đơn hàng theo trạng thái</option>
                <option value="{{ route('admin.reports.tonkho') }}" selected>Xuất – Nhập – Tồn kho</option>
                <option value="{{ route('admin.reports.banchay') }}">Sản phẩm bán chạy</option>
            </select>
        </div>
    </div>

    {{-- Bộ lọc --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.tonkho') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="productName" class="form-control" value="{{ request('productName') }}" placeholder="Nhập tên sản phẩm...">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sắp xếp theo</label>
                    <select name="sortBy" class="form-select">
                        <option value="">-- Mặc định --</option>
                        <option value="tonKho" {{ request('sortBy')=='tonKho'?'selected':'' }}>Tồn kho</option>
                        <option value="soLuongNhap" {{ request('sortBy')=='soLuongNhap'?'selected':'' }}>Số lượng nhập</option>
                        <option value="soLuongBan" {{ request('sortBy')=='soLuongBan'?'selected':'' }}>Số lượng bán</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Chart --}}
    <div class="card">
        <div class="card-body">
            <h5 class="fw-bold mb-3">📊 Xuất – Nhập – Tồn kho</h5>
            @if($data->isEmpty())
                <div class="alert alert-warning">Không có dữ liệu</div>
            @else
                <canvas id="tonKhoChart" height="200"></canvas>
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
    const ctx = document.getElementById('tonKhoChart');
    if(ctx){
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data->pluck('tenSanPham')) !!},
                datasets: [
                    {
                        label:'Nhập',
                        data:{!! json_encode($data->pluck('soLuongNhap')) !!},
                        backgroundColor:'#198754'
                    },
                    {
                        label:'Bán',
                        data:{!! json_encode($data->pluck('soLuongBan')) !!},
                        backgroundColor:'#dc3545'
                    },
                    {
                        label:'Tồn kho',
                        data:{!! json_encode($data->pluck('tonKho')) !!},
                        backgroundColor:'#0d6efd'
                    }
                ]
            },
            options:{
                indexAxis:'y',
                responsive:true,
                plugins:{ legend:{ position:'top' } },
                scales:{ x:{ beginAtZero:true } }
            }
        });
    }
});
</script>
@endsection
