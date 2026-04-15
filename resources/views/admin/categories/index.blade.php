@extends('layouts.admin')

@section('title', 'Quản lý danh mục')
@section('header', 'Quản lý danh mục')

@section('content')
<div class="card mt-3">

    {{-- Header --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 text-primary fw-bold">Quản lý danh mục</h5>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                Thêm mới
            </a>

            {{-- Tìm kiếm --}}
            <form method="GET" action="{{ route('admin.categories.index') }}">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Tìm theo tên danh mục..."
                       value="{{ request('search') }}">
            </form>
        </div>
    </div>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success m-3 mb-0">
            {{ session('success') }}
        </div>
    @endif

    {{-- Bảng dữ liệu --}}
    <div class="card-body p-0">
        <table class="table table-hover table-striped m-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id_danh_muc }}</td>

                    <td>{{ $category->ten_danh_muc }}</td>

                    <td>{{ $category->mo_ta }}</td>

                    <td>
                        <a href="{{ route('admin.categories.edit', $category->id_danh_muc) }}"
                           class="btn btn-sm btn-warning">
                            Sửa
                        </a>

                        <form action="{{ route('admin.categories.destroy', $category->id_danh_muc) }}"
                              method="POST"
                              style="display:inline-block"
                              onsubmit="return confirm('Xóa danh mục này?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Không có dữ liệu</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection