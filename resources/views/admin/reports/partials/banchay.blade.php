@extends('layouts.admin')

@section('title', 'Sản phẩm bán chạy')
@section('header', 'Sản phẩm bán chạy')

@section('content')
<div class="container-fluid py-3">

    {{-- Thanh chọn loại thống kê --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label fw-bold">Loại thống kê</label>
            <select id="reportType" class="form-select">
                <option value="{{ route('admin.reports.doanhthu') }}">
                    Doanh thu theo thời gian
                </option>
                <option value="{{ route('admin.reports.donhang') }}">
                    Đơn hàng theo trạng thái
                </option>
                <option value="{{ route('admin.reports.tonkho') }}">
                    Xuất – Nhập – Tồn kho
                </option>
                <option value="{{ route('admin.reports.banchay') }}" selected>
                    Sản phẩm bán chạy
                </option>
            </select>
        </div>
    </div>

    {{-- Bộ lọc --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET"
                  action="{{ route('admin.reports.banchay') }}"
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
                    <label class="form-label">Top sản phẩm</label>
                    <input type="number"
                           name="top"
                           class="form-control"
                           min="1"
                           value="{{ request('top', 10) }}">
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Lọc dữ liệu
                    </button>

                    {{-- Xuất Excel --}}
                    <a href="{{ route('admin.reports.banchay.export', request()->all()) }}"
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
            <h5 class="fw-bold mb-3">📊 Biểu đồ sản phẩm bán chạy</h5>

            @if($data->isEmpty())
                <div class="alert alert-warning mb-0">
                    Không có dữ liệu để hiển thị
                </div>
            @else
                <div style="height: 420px;">
                    <canvas id="banChayChart"></canvas>
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

    // Biểu đồ sản phẩm bán chạy
    const ctx = document.getElementById('banChayChart');

    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data->pluck('ten_san_pham')) !!},
                datasets: [{
                    label: 'Tổng số lượng bán',
                    data: {!! json_encode($data->pluck('tongBan')) !!},
                    backgroundColor: 'rgba(13, 110, 253, 0.7)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection