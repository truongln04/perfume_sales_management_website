@extends('layouts.admin')
@section('title','Quản lý sản phẩm')
@section('header','Quản lý sản phẩm')

@section('content')
<div class="container-fluid">
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Thêm mới</a>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-hover table-striped">
        <thead class="table-light">
            <tr>
                <th>Mã SP</th>
                <th>Mã DM</th>
                <th>Mã TH</th>
                <th>Mã NCC</th>
                <th>Tên SP</th>
                <th>Hình ảnh</th>
                <th>Mô tả</th>
                <th>Giá nhập</th>
                <th>Giá bán</th>
                <th>KM%</th>
                <th>Giá sau KM</th>
                <th>Số lượng tồn</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $p)
            <tr>
                <td>{{ $p->id_san_pham }}</td>
                <td>{{ $p->id_danh_muc }}</td>
                <td>{{ $p->id_thuong_hieu }}</td>
                <td>{{ $p->id_ncc }}</td>
                <td>{{ $p->ten_san_pham }}</td>
                <td>
    @if($p->hinh_anh)
        @php
            $src = Str::startsWith($p->hinh_anh, ['http://','https://'])
                ? $p->hinh_anh
                : asset('images/'.$p->hinh_anh);
        @endphp
        <img src="{{ $src }}" alt="{{ $p->ten_san_pham }}" width="60" height="60" class="rounded">
    @else
        <img src="{{ asset('images/default.jpg') }}" alt="default" width="60" height="60" class="rounded">
    @endif
</td>


                <td style="max-width:200px">
                    {{ Str::limit($p->mo_ta,60) }}
                </td>
                <td>{{ $p->gia_nhap ? number_format($p->gia_nhap,0,',','.') . ' đ' : '—' }}</td>
                <td>{{ $p->gia_ban ? number_format($p->gia_ban,0,',','.') . ' đ' : '—' }}</td>
                <td>{{ $p->km_phan_tram ? $p->km_phan_tram.'%' : '—' }}</td>
                <td>
                    @if($p->gia_ban && $p->km_phan_tram)
                        {{ number_format($p->gia_ban * (1 - $p->km_phan_tram/100),0,',','.') }} đ
                    @else
                        —
                    @endif
                </td>
                <td>{{ $p->so_luong_ton }}</td>
                <td>
                    <span class="badge {{ $p->trang_thai ? 'bg-success':'bg-secondary' }}">
                        {{ $p->trang_thai ? 'Đang bán':'Chưa bán' }}
                    </span>
                </td>
                <td class="d-flex gap-2">
                    <a href="{{ route('products.edit',$p) }}" class="btn btn-sm btn-outline-primary">Sửa</a>
                    <form action="{{ route('products.destroy',$p) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="14" class="text-center py-4">Không có dữ liệu</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
