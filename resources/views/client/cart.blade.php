@extends('layouts.client')
@section('title','Giỏ hàng')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4">Giỏ hàng</h3>

    @php
        $totalPrice = collect($cartItems)->sum(fn($item) => $item['gia_ban'] * $item['quantity']);
    @endphp

    @if(empty($cartItems))
        <p class="text-muted">Giỏ hàng của bạn đang trống.</p>
    @else
        <form action="{{ route('client.cart.remove') }}" method="POST">
            @csrf @method('DELETE')
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Ảnh</th>
                            <th>Sản phẩm</th>
                            <th class="text-end">Đơn giá</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Thành tiền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $id => $item)
                            <tr>
                                <td><input type="checkbox" name="selected[]" value="{{ $id }}" class="select-item"></td>
                                <td><img src="{{ $item['hinh_anh'] }}" style="width:60px;height:60px;object-fit:cover"></td>
                                <td>{{ $item['ten_san_pham'] }}</td>
                                <td class="text-end">{{ number_format($item['gia_ban'],0,',','.') }} ₫</td>
                                <td class="text-center">
                                    <form action="{{ route('client.cart.update',$id) }}" method="POST" class="d-inline-flex">
                                        @csrf @method('PUT')
                                        <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary btn-sm">-</button>
                                        <input type="text" readonly value="{{ $item['quantity'] }}" class="form-control form-control-sm text-center mx-1" style="width:50px">
                                        <button type="submit" name="action" value="increase" class="btn btn-outline-secondary btn-sm">+</button>
                                    </form>
                                </td>
                                <td class="text-end">{{ number_format($item['gia_ban'] * $item['quantity'],0,',','.') }} ₫</td>
                                <td>
                                    <form action="{{ route('client.cart.removeOne',$id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <h4 class="mb-0">
                    Tổng tiền: <span class="text-danger fw-bold">{{ number_format($totalPrice,0,',','.') }} ₫</span>
                </h4>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h4 class="mb-0">
                        Tổng tiền: <span class="text-danger fw-bold">{{ number_format($totalPrice,0,',','.') }} ₫</span>
                    </h4>
                    <div class="d-flex align-items-center" style="gap:12px">
                        <button class="btn btn-outline-danger btn-sm px-3 fw-bold rounded-pill shadow-sm">🗑 Xóa đã chọn</button>
                        <a href="{{ route('client.checkout') }}" class="btn btn-primary btn-sm px-3 fw-bold rounded-pill shadow-sm">
                            🛒 Thanh toán
                        </a>
                    </div>
                </div>

            </div>
        </form>
    @endif
</div>

<script>
document.getElementById('select-all')?.addEventListener('change', e => {
    document.querySelectorAll('.select-item').forEach(cb => cb.checked = e.target.checked);
});
</script>
@endsection
