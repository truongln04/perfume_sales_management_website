@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Sửa tài khoản</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('accounts.update', $account->id_tai_khoan) }}" method="POST">
            @csrf
            @method('PUT')

            <input class="form-control mb-2" name="ten_hien_thi"
                   value="{{ $account->ten_hien_thi }}">

            <input class="form-control mb-2" name="email"
                   value="{{ $account->email }}">

            <input class="form-control mb-2" name="sdt"
                   value="{{ $account->sdt }}">

            <input class="form-control mb-2" name="google_id"
                   value="{{ $account->google_id }}">

            <input class="form-control mb-2" name="anh_dai_dien"
                   value="{{ $account->anh_dai_dien }}">

            <input class="form-control mb-2" type="password"
                   name="mat_khau" placeholder="Để trống nếu không đổi">

            <select name="vai_tro" class="form-control mb-3">
                <option value="ADMIN" {{ $account->vai_tro=='ADMIN'?'selected':'' }}>ADMIN</option>
                <option value="NHANVIEN" {{ $account->vai_tro=='NHANVIEN'?'selected':'' }}>NHANVIEN</option>
                <option value="KHACHHANG" {{ $account->vai_tro=='KHACHHANG'?'selected':'' }}>KHACHHANG</option>
            </select>

            <button class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>
@endsection