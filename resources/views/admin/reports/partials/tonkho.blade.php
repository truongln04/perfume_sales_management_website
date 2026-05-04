@extends('layouts.admin')

@section('title', 'Xuất – Nhập – Tồn kho')
@section('header', 'Xuất – Nhập – Tồn kho')

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
                <option value="{{ route('admin.reports.tonkho') }}" selected>
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
                  action="{{ route('admin.reports.tonkho') }}"
                  class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text"
                           name="productName"
                           class="form-control"
                           value="{{ request('productName') }}"
                           placeholder="Nhập tên sản phẩm...">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sắp xếp theo</label>
                    <select name="sortBy" class="form-select">
                        <option value="">-- Mặc định --</option>

                        <option value="tonKho"
                            {{ request('sortBy') == 'tonKho' ? 'selected' : '' }}>
                            Tồn kho
                        </option>

                        <option value="soLuongNhap"
                            {{ request('sortBy') == 'soLuongNhap' ? 'selected' : '' }}>
                            Số lượng nhập
                        </option>

                        <option value="soLuongBan"
                            {{ request('sortBy') == 'soLuongBan' ? 'selected' : '' }}>
                            Số lượng bán
                        </option>
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Lọc dữ liệu
                    </button>

                    {{-- Nút xuất Excel --}}
                    <a href="{{ route('admin.reports.tonkho.export') }}"
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
            <h5 class="fw-bold mb-3">📊 Xuất – Nhập – Tồn kho</h5>

            @if($data->isEmpty())
                <div class="alert alert-warning mb-0">
                    Không có dữ liệu
                </div>
            @else
                <div style="height: 450px;">
                    <canvas id="tonKhoChart"></canvas>
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

    // Biểu đồ tồn kho
    const ctx = document.getElementById('tonKhoChart');

    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data->pluck('tenSanPham')) !!},
                datasets: [
                    {
                        label: 'Nhập',
                        data: {!! json_encode($data->pluck('soLuongNhap')) !!},
                        backgroundColor: '#198754'
                    },
                    {
                        label: 'Bán',
                        data: {!! json_encode($data->pluck('soLuongBan')) !!},
                        backgroundColor: '#dc3545'
                    },
                    {
                        label: 'Tồn kho',
                        data: {!! json_encode($data->pluck('tonKho')) !!},
                        backgroundColor: '#0d6efd'
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
@endsection