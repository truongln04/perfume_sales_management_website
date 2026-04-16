@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
<div class="col-md-5">

<div class="card shadow p-4">
<h3 class="text-center mb-4">Đăng nhập</h3>

<form method="POST" action="{{ route('login') }}">
@csrf

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" value="{{ old('email') }}">
</div>

<div class="mb-3">
<label>Mật khẩu</label>
<input type="password" name="password" class="form-control">
</div>

<button class="btn btn-primary w-100">Đăng nhập</button>

<div class="text-center mt-3">
<a href="{{ route('register') }}">Chưa có tài khoản?</a>
</div>

</form>
</div>

</div>
</div>
@endsection