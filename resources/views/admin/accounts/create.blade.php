@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Thêm tài khoản</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.accounts.store') }}" method="POST">
            @csrf
            
            <input class="form-control mb-2" name="ten_hien_thi" placeholder="Tên hiển thị">
            <input class="form-control mb-2" name="email" placeholder="Email">
            <input class="form-control mb-2" name="sdt" placeholder="SĐT">
            <input class="form-control mb-2" name="google_id" placeholder="Google ID">
            <input class="form-control mb-2" name="anh_dai_dien" placeholder="Ảnh đại diện URL">
            <input class="form-control mb-2" type="password" name="mat_khau" placeholder="Mật khẩu">

            <select name="vai_tro" class="form-control mb-3">
                <option value="ADMIN">ADMIN</option>
                <option value="NHANVIEN">NHANVIEN</option>
                <option value="KHACHHANG">KHACHHANG</option>
            </select>

            <button class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>
@endsection