@extends('layouts.admin')
@section('title','Quản lý nhà cung cấp')
@section('header','Quản lý nhà cung cấp')

@section('content')
<div class="card mt-3">

    {{-- Header --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 text-primary fw-bold">Quản lý nhà cung cấp</h5>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                Thêm mới
            </a>

            {{-- Ô tìm kiếm --}}
            <form method="GET" action="{{ route('admin.suppliers.index') }}">
                <input type="text"
                       name="keyword"
                       class="form-control"
                       placeholder="Tìm theo tên hoặc email..."
                       value="{{ request('keyword') }}">
            </form>
        </div>
    </div>

    {{-- Nội dung --}}
    <div class="card-body p-0">
        @if(session('success'))
            <div class="alert alert-success m-2">{{ session('success') }}</div>
        @endif

        <table class="table table-hover table-striped m-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tên NCC</th>
                    <th>Địa chỉ</th>
                    <th>SĐT</th>
                    <th>Email</th>
                    <th>Ghi chú</th>
                    <th class="text-center">Hành động</th>
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
                        <td class="text-center">
                            <a href="{{ route('admin.suppliers.edit',$s) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('admin.suppliers.destroy',$s) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Xóa nhà cung cấp này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    <div class="card-footer">
        {{ $suppliers->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
