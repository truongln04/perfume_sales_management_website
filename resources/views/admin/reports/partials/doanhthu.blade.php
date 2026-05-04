@extends('layouts.admin')

@section('title', 'Doanh thu theo thời gian')
@section('header', 'Doanh thu theo thời gian')

@section('content')
<div class="container-fluid py-3">

    {{-- Thanh chọn loại thống kê --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label fw-bold">Loại thống kê</label>
            <select id="reportType" class="form-select">
                <option value="{{ route('admin.reports.doanhthu') }}" selected>
                    Doanh thu theo thời gian
                </option>
                <option value="{{ route('admin.reports.donhang') }}">
                    Đơn hàng theo trạng thái
                </option>
                <option value="{{ route('admin.reports.tonkho') }}">
                    Xuất – Nhập – Tồn kho
                </option>
                <option value="{{ route('admin.reports.banchay') }}">
                    Sản phẩm bán chạy
                </option>
            </select>
        </div>
    </div>

    {{-- Bộ lọc + Xuất Excel --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET"
                  action="{{ route('admin.reports.doanhthu') }}"
                  class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label">Từ ngày</label>
                    <input type="date"
                           name="fromDate"
                           class="form-control"
                           value="{{ request('fromDate') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date"
                           name="toDate"
                           class="form-control"
                           value="{{ request('toDate') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Phương thức thanh toán</label>
                    <select name="payment" class="form-select">
                        <option value="">-- Tất cả --</option>
                        <option value="COD"
                            {{ request('payment') == 'COD' ? 'selected' : '' }}>
                            COD
                        </option>
                        <option value="ONLINE"
                            {{ request('payment') == 'ONLINE' ? 'selected' : '' }}>
                            Online
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Lọc dữ liệu
                    </button>

                    {{-- Nút xuất Excel --}}
                    <a href="{{ route('admin.reports.doanhthu.export', request()->all()) }}"
                       class="btn btn-success w-100">
                        Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Biểu đồ --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">📊 Doanh thu theo thời gian</h5>

            @if($data->isEmpty())
                <div class="alert alert-warning mb-0">
                    Không có dữ liệu
                </div>
            @else
                <div style="height: 400px;">
                    <canvas id="doanhThuChart"></canvas>
                </div>
            @endif
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Chuyển trang khi đổi loại thống kê
    const reportType = document.getElementById('reportType');

    if (reportType) {
        reportType.addEventListener('change', function (e) {
            window.location.href = e.target.value;
        });
    }

    // Chart doanh thu
    const ctx = document.getElementById('doanhThuChart');

    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($data->pluck('ngay')) !!},
                datasets: [{
                    label: 'Doanh thu',
                    data: {!! json_encode($data->pluck('doanhThu')) !!},
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.2)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
@endsection