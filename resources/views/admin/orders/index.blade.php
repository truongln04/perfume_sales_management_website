@extends('layouts.admin')

@section('content')
<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 text-primary fw-bold">Quản lý đơn hàng</h5>

        <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex gap-2">
            <input type="text" name="keyword" class="form-control"
                   style="width:260px"
                   placeholder="Tìm theo tên hoặc SDT..."
                   value="{{ request('keyword') }}">
            <button class="btn btn-primary">Tìm</button>
        </form>
    </div>

    <div class="card-body p-0">
        <table class="table table-hover table-striped m-0">
            <thead class="table-light">
                <tr>
                    <th>Mã ĐH</th>
                    <th>Người nhận</th>
                    <th>SĐT</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>PTTT</th>
                    <th>TT Thanh toán</th>
                    <th>Trạng thái</th>
                    <th width="180">Hành động</th>
                </tr>
            </thead>

            <tbody>
            @forelse($orders as $o)
                <tr>
                    <td>{{ $o->id_don_hang }}</td>
                    <td>{{ $o->ho_ten_nhan }}</td>
                    <td>{{ $o->sdt_nhan }}</td>
                    <td>{{ $o->ngay_dat?->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($o->tong_tien) }} đ</td>
                    <td>{{ $o->phuong_thuc_tt }}</td>
                    <td>
                        <span class="badge bg-info">
                            {{ \App\Models\Order::paymentStatusLabels()[$o->trang_thai_tt] ?? $o->trang_thai_tt }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-primary">
                            {{ \App\Models\Order::statusLabels()[$o->trang_thai] ?? $o->trang_thai }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $o) }}"
                           class="btn btn-sm btn-info">
                           Chi tiết
                        </a>

                        <a href="{{ route('admin.orders.edit', $o) }}"
                           class="btn btn-sm btn-warning">
                           Cập nhật
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-4">
                        Không có đơn hàng nào
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}

    </div>
</div>
@endsection
