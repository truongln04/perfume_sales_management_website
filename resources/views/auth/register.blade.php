@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
<div class="col-md-5">

<div class="card shadow p-4">
<h3 class="text-center mb-4">Đăng ký</h3>

<form method="POST" action="{{ route('register') }}">
@csrf

<div class="mb-3">
<label>Tên hiển thị</label>
<input type="text" name="ten_hien_thi" class="form-control">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control">
</div>

<div class="mb-3">
<label>SĐT</label>
<input type="text" name="sdt" class="form-control">
</div>

<div class="mb-3">
<label>Mật khẩu</label>
<input type="password" name="password" class="form-control">
</div>

<div class="mb-3">
<label>Nhập lại mật khẩu</label>
<input type="password" name="password_confirmation" class="form-control">
</div>

<button class="btn btn-success w-100">Đăng ký</button>

</form>
</div>

</div>
</div>
@endsection