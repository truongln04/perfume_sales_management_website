@extends('layouts.admin')
@section('title','Quản lý phiếu nhập')
@section('header','Quản lý phiếu nhập')

@section('content')
<div class="container-fluid">
    <a href="{{ route('receipts.create') }}" class="btn btn-primary mb-3">Thêm mới</a>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mã PN</th><th>Ngày nhập</th><th>Tổng tiền</th><th>Ghi chú</th><th>Hành động</th>
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
                    <a href="{{ route('receipts.show',$r) }}" class="btn btn-sm btn-outline-info">Xem chi tiết</a>
                    <form action="{{ route('receipts.destroy',$r) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa phiếu nhập này?')">Xóa</button>
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
