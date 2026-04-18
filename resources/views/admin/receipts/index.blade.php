@extends('layouts.admin')

@section('title', 'Quản lý phiếu nhập')
@section('header', 'Quản lý phiếu nhập')

@section('content')
<div class="card mt-3">

    {{-- Header --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 text-primary fw-bold">Quản lý phiếu nhập</h5>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.receipts.create') }}" class="btn btn-primary">
                Thêm mới
            </a>

            {{-- Ô tìm kiếm (không có nút) --}}
            <form method="GET" action="{{ route('admin.receipts.index') }}">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Tìm theo mã PN hoặc ghi chú..."
                       value="{{ request('search') }}">
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
                    <th>Mã PN</th>
                    <th>Ngày nhập</th>
                    <th>Tổng tiền</th>
                    <th>Ghi chú</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            @forelse($receipts as $r)
                <tr>
                    <td>{{ $r->id_phieu_nhap }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->ngay_nhap)->format('d/m/Y') }}</td>
                    <td>{{ number_format($r->tong_tien,0,',','.') }} đ</td>
                    <td>{{ $r->ghi_chu ?? 'Không có ghi chú' }}</td>
                    <td>
                        <a href="{{ route('admin.receipts.show',$r) }}" class="btn btn-sm btn-info">Xem</a>
                        <form action="{{ route('admin.receipts.destroy',$r) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Xóa phiếu nhập này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    <div class="card-footer">
        {{ $receipts->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
