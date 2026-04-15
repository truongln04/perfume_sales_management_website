@extends('layouts.admin')

@section('title', 'Quản lý thương hiệu')
@section('header', 'Quản lý thương hiệu')

@section('content')
<div class="card mt-3">

    {{-- Header --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 text-primary fw-bold">Quản lý thương hiệu</h5>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
                Thêm mới
            </a>

            {{-- Ô tìm kiếm (nếu cần sau này) --}}
            <form method="GET" action="{{ route('admin.brands.index') }}">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Tìm theo tên thương hiệu..."
                       value="{{ request('search') }}">
            </form>
        </div>
    </div>

    {{-- Nội dung --}}
    <div class="card-body p-0">
        <table class="table table-hover table-striped m-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Logo</th>
                    <th>Tên thương hiệu</th>
                    <th>Quốc gia</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
            @forelse($brands as $brand)
                <tr>
                    <td>{{ $brand->id_thuong_hieu }}</td>

                    <td>
                        @if($brand->logo)
                            <img src="{{ $brand->logo }}"
                                 width="60"
                                 height="40"
                                 class="border rounded p-1"
                                 style="object-fit:contain;">
                        @else
                            N/A
                        @endif
                    </td>

                    <td>{{ $brand->ten_thuong_hieu }}</td>

                    <td>{{ $brand->quoc_gia }}</td>

                    <td>
                        <a href="{{ route('admin.brands.edit', $brand->id_thuong_hieu) }}"
                           class="btn btn-sm btn-warning">
                            Sửa
                        </a>

                        <form action="{{ route('admin.brands.destroy', $brand->id_thuong_hieu) }}"
                              method="POST"
                              style="display:inline-block"
                              onsubmit="return confirm('Xóa thương hiệu này?')">

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
<td colspan="5" class="text-center">Không có dữ liệu</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection