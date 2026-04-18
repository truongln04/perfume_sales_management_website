@extends('layouts.admin')
@section('title','Quản lý sản phẩm')
@section('header','Quản lý sản phẩm')

@section('content')
<div class="card mt-3">

    {{-- Header --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 text-primary fw-bold">Quản lý sản phẩm</h5>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Thêm mới</a>
    </div>

    {{-- Form lọc nâng cao --}}
    <div class="card-body border-bottom">
        <form action="{{ route('products.index') }}" method="GET" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="keyword" value="{{ request('keyword') }}"
                       class="form-control" placeholder="Tên hoặc mã SP...">
            </div>
            <div class="col-md-2">
                <select name="id_danh_muc" class="form-select">
                    <option value="">--Danh mục--</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id_danh_muc }}" {{ request('id_danh_muc')==$c->id_danh_muc?'selected':'' }}>
                            {{ $c->ten_danh_muc }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="id_thuong_hieu" class="form-select">
                    <option value="">--Thương hiệu--</option>
                    @foreach($brands as $b)
                        <option value="{{ $b->id_thuong_hieu }}" {{ request('id_thuong_hieu')==$b->id_thuong_hieu?'selected':'' }}>
                            {{ $b->ten_thuong_hieu }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="trang_thai" class="form-select">
                    <option value="">--Trạng thái--</option>
                    <option value="1" {{ request('trang_thai')==='1'?'selected':'' }}>Đang bán</option>
                    <option value="0" {{ request('trang_thai')==='0'?'selected':'' }}>Chưa bán</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">Lọc</button>
            </div>
        </form>
    </div>

    {{-- Nội dung --}}
    <div class="card-body p-0">
        @if(session('success'))
            <div class="alert alert-success m-2">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-striped m-0 align-middle">
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
                        <th class="text-center">Hành động</th>
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
                                @php
                                    $src = $p->hinh_anh && Str::startsWith($p->hinh_anh, ['http://','https://'])
                                        ? $p->hinh_anh
                                        : asset('images/'.$p->hinh_anh);
                                @endphp
                                <img src="{{ $src ?? asset('images/default.jpg') }}" 
                                     alt="{{ $p->ten_san_pham }}" width="60" height="60" class="rounded">
                            </td>
                            <td style="max-width:200px">{{ Str::limit($p->mo_ta,60) }}</td>
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
                            <td class="text-center">
                                <a href="{{ route('products.edit',$p) }}" class="btn btn-sm btn-warning">Sửa</a>
                                <form action="{{ route('products.destroy',$p) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Xóa sản phẩm này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="14" class="text-center py-4">Không có dữ liệu</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Phân trang --}}
    <div class="card-footer">
        {{ $products->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
