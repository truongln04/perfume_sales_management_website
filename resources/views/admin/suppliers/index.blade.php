@extends('layouts.admin')
@section('title','Quản lý nhà cung cấp')
@section('header','Quản lý nhà cung cấp')

@section('content')
<div class="container-fluid">
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">Thêm mới</a>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th><th>Tên NCC</th><th>Địa chỉ</th><th>SĐT</th><th>Email</th><th>Ghi chú</th><th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $s)
            <tr>
                <td>{{ $s->id_ncc }}</td>
                <td>{{ $s->ten_ncc }}</td>
                <td>{{ $s->dia_chi }}</td>
                <td>{{ $s->sdt }}</td>
                <td>{{ $s->email }}</td>
                <td>{{ $s->ghi_chu }}</td>
                <td>
                    <a href="{{ route('suppliers.edit',$s) }}" class="btn btn-sm btn-outline-primary">Sửa</a>
                    <form action="{{ route('suppliers.destroy',$s) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa nhà cung cấp này??')">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
