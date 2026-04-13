@extends('layouts.admin')

@section('title', 'Quản lý danh mục')
@section('header', 'Quản lý danh mục')

@section('content')
<div class="container-fluid">
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Thêm mới</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $c)
                <tr>
                    <td>{{ $c->id_danh_muc }}</td>
                    <td>{{ $c->ten_danh_muc }}</td>
                    <td>{{ $c->mo_ta }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $c) }}" class="btn btn-sm btn-outline-primary">Sửa</a>
                        <form action="{{ route('categories.destroy', $c) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa danh mục này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Không có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
