@extends('layouts.admin')

@section('title', 'Đơn hàng theo trạng thái')
@section('header', 'Đơn hàng theo trạng thái')

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
                <option value="{{ route('admin.reports.donhang') }}" selected>
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
                  action="{{ route('admin.reports.donhang') }}"
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

                 {{-- Trạng thái đơn hàng --}}
                <div class="col-md-3">
                    <label class="form-label">Trạng thái đơn hàng</label>
                    <select name="orderStatus" class="form-select">
                        <option value="">-- Tất cả --</option>

                        {{-- PHẢI dùng đúng value theo Order.php --}}
                        <option value="CHO_XAC_NHAN"
                            {{ request('orderStatus') == 'CHO_XAC_NHAN' ? 'selected' : '' }}>
                            Chờ xác nhận
                        </option>

                        <option value="DA_XAC_NHAN"
                            {{ request('orderStatus') == 'DA_XAC_NHAN' ? 'selected' : '' }}>
                            Đã xác nhận
                        </option>

                        <option value="DANG_GIAO"
                            {{ request('orderStatus') == 'DANG_GIAO' ? 'selected' : '' }}>
                            Đang giao
                        </option>

                        <option value="HOAN_THANH"
                            {{ request('orderStatus') == 'HOAN_THANH' ? 'selected' : '' }}>
                            Hoàn thành
                        </option>

                        <option value="TRA_HANG"
                            {{ request('orderStatus') == 'TRA_HANG' ? 'selected' : '' }}>
                            Trả hàng
                        </option>

                        <option value="HUY"
                            {{ request('orderStatus') == 'HUY' ? 'selected' : '' }}>
                            Hủy
                        </option>
                    </select>
                </div>


                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Lọc dữ liệu
                    </button>

                    {{-- Nút xuất Excel --}}
                    <a href="{{ route('admin.reports.donhang.export', request()->all()) }}"
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
            <h5 class="fw-bold mb-3">📊 Đơn hàng theo trạng thái</h5>

            @if($data->isEmpty())
                <div class="alert alert-warning mb-0">
                    Không có dữ liệu
                </div>
            @else
                <div style="height: 400px;">
                    <canvas id="donHangChart"></canvas>
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

    // Biểu đồ đơn hàng
    const ctx = document.getElementById('donHangChart');

    if (ctx) {
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($data->pluck('trang_thai')) !!},
                datasets: [{
                    data: {!! json_encode($data->pluck('soLuong')) !!},
                    backgroundColor: [
                        '#0d6efd',
                        '#198754',
                        '#ffc107',
                        '#dc3545',
                        '#6f42c1'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }
});
</script>
@endsection