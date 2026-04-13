@extends('layouts.admin')

@section('title', 'Trang chủ quản trị')
@section('header', 'Quản trị hệ thống')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold text-primary">Chào mừng bạn đến với bảng điều khiển quản lý nước hoa</h3>
    <p class="text-muted">Sự tinh tế nằm trong từng giọt hương</p>

    <!-- Các box thống kê -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold">120</h4>
                    <p class="text-muted">Tài khoản</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold">85</h4>
                    <p class="text-muted">Sản phẩm</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold">42</h4>
                    <p class="text-muted">Đơn hàng mới</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold">12.5M</h4>
                    <p class="text-muted">Doanh thu tháng</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông báo hệ thống -->
    <div class="alert alert-info">
        <h5 class="fw-bold">Thông báo hệ thống</h5>
        <p>Hãy kiểm tra lại kho hàng định kỳ để đảm bảo chất lượng sản phẩm. Đừng quên cập nhật thường xuyên để khách hàng có thêm lựa chọn.</p>
    </div>

    <!-- Quote -->
    <blockquote class="blockquote text-center mt-4">
        <p class="mb-0">“Quản lý tốt là nghệ thuật biến sự phức tạp thành đơn giản.”</p>
    </blockquote>
</div>
@endsection
