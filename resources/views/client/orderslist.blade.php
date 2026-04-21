@extends('layouts.client')
@section('title','Đơn hàng của tôi')

@section('content')
<div class="container py-4">

    {{-- Tabs trạng thái --}}
    @php
        $statusTabs = [
            'ALL' => ['label'=>'Tất cả','color'=>'secondary'],
            'CHO_XAC_NHAN' => ['label'=>'Chờ xác nhận','color'=>'warning'],
            'DA_XAC_NHAN' => ['label'=>'Đã xác nhận','color'=>'info'],
            'DANG_GIAO' => ['label'=>'Đang giao','color'=>'primary'],
            'HOAN_THANH' => ['label'=>'Hoàn thành','color'=>'success'],
            'TRA_HANG' => ['label'=>'Trả hàng','color'=>'dark'],
            'HUY' => ['label'=>'Hủy','color'=>'danger'],
        ];
        $activeTab = request('status','ALL');
    @endphp

    <div class="mb-3 d-flex justify-content-center flex-wrap gap-2">
        @foreach($statusTabs as $key=>$tab)
            <a href="{{ route('client.orderslist',['status'=>$key]) }}"
               class="btn btn-sm btn-{{ $activeTab==$key ? $tab['color'] : 'outline-'.$tab['color'] }}">
                {{ $tab['label'] }}
            </a>
        @endforeach
    </div>

    {{-- Bảng đơn hàng --}}
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Mã ĐH</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Phương thức TT</th>
                    <th>Người nhận</th>
                    <th>SDT</th>
                    <th>Địa chỉ</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái TT</th>
                    <th>Trạng thái ĐH</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $o)
                    <tr>
                        <td>{{ $o->id_don_hang }}</td>
                        <td>{{ $o->ngay_dat ? \Carbon\Carbon::parse($o->ngay_dat)->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ number_format($o->tong_tien,0,',','.') }} ₫</td>
                        <td>{{ $o->phuong_thuc_tt }}</td>
                        <td>{{ $o->ho_ten_nhan }}</td>
                        <td>{{ $o->sdt_nhan }}</td>
                        <td class="text-truncate" style="max-width:220px">{{ $o->dia_chi_giao }}</td>
                        <td class="text-truncate" style="max-width:200px">{{ $o->ghi_chu }}</td>
                        <td>{{ $o->trang_thai_tt }}</td>
                        <td>
                            @php $tab = $statusTabs[$o->trang_thai] ?? null; @endphp
                            <span class="badge bg-{{ $tab['color'] ?? 'secondary' }}">
                                {{ $tab['label'] ?? $o->trang_thai }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('client.orders.show',$o->id_don_hang) }}" class="btn btn-sm btn-outline-secondary">Xem</a>
                                @if($o->trang_thai=='CHO_XAC_NHAN')
                                    <form method="POST" action="{{ route('client.orders.cancel',$o->id_don_hang) }}">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Xác nhận hủy đơn hàng?')">Hủy</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted">Không có đơn hàng</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
