@extends('layouts.admin')
@section('title','Trang chủ quản trị')
@section('header','Quản trị hệ thống')

@section('content')
<div class="container-fluid p-4">

    <div class="text-center mb-5">
        <h1 class="fw-bold text-dark display-4">Quản trị hệ thống</h1>
        <p class="text-muted fs-5">Chào mừng bạn đến với bảng điều khiển quản lý nước hoa</p>
        <p class="fst-italic text-secondary">🌸 “Sự tinh tế nằm trong từng giọt hương” 🌸</p>
    </div>

    <!-- Các box thống kê -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="shadow rounded p-4 bg-white text-center">
                {{-- <h3 class="fw-bold text-primary">{{ $taiKhoan }}</h3> --}}
                <p class="m-0 text-muted">Tài khoản</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="shadow rounded p-4 bg-white text-center">
                {{-- <h3 class="fw-bold text-danger">{{ $sanPham }}</h3> --}}
                <p class="m-0 text-muted">Sản phẩm</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="shadow rounded p-4 bg-white text-center">
                {{-- <h3 class="fw-bold text-success">{{ $donHangMoi }}</h3> --}}
                <p class="m-0 text-muted">Đơn hàng mới</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="shadow rounded p-4 bg-white text-center">
                {{-- <h3 class="fw-bold text-warning">{{ number_format($doanhThu,0,',','.') }} đ</h3> --}}
                <p class="m-0 text-muted">Doanh thu</p>
            </div>
        </div>
    </div>

    <!-- Thông báo hệ thống -->
    <div class="card shadow-sm mt-5">
        <div class="card-body text-center">
            <h5 class="text-primary fw-bold">📢 Thông báo hệ thống</h5>
            <p class="text-muted">Hãy kiểm tra lại kho hàng định kỳ để đảm bảo chất lượng sản phẩm.</p>
            <p class="text-muted">Đừng quên cập nhật thương hiệu mới để khách hàng có thêm lựa chọn.</p>
        </div>
    </div>

    <!-- Quote -->
    <div class="mt-4 text-center">
        <blockquote class="blockquote">
            <p class="mb-0">“Quản lý tốt là nghệ thuật biến sự phức tạp thành đơn giản.”</p>
        </blockquote>
    </div>
</div>
@endsection
