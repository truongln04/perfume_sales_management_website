@extends('layouts.admin')
@section('title','Quản lý thương hiệu')
@section('header','Quản lý thương hiệu')

@section('content')
<div class="container-fluid">
    <a href="{{ route('brands.create') }}" class="btn btn-primary mb-3">Thêm mới</a>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th><th>Tên thương hiệu</th><th>Quốc gia</th><th>Logo</th><th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($brands as $b)
            <tr>
                <td>{{ $b->id_thuong_hieu }}</td>
                <td>{{ $b->ten_thuong_hieu }}</td>
                <td>{{ $b->quoc_gia }}</td>
                <td>
                    @if($b->logo)
                        <img src="{{ $b->logo }}" alt="{{ $b->ten_thuong_hieu }}" width="60" height="40" style="object-fit:contain;">
                    @else
                        <span class="text-muted">Không có</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('brands.edit',$b) }}" class="btn btn-sm btn-outline-primary">Sửa</a>
                    <form action="{{ route('brands.destroy',$b) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa thương hiệu này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
