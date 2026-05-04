@extends('layouts.client')
@section('title','Giỏ hàng')

@section('content')

<div class="container py-4">
    <h3 class="fw-bold mb-4">Giỏ hàng</h3>

    @if($cartItems->isEmpty())
        <p class="text-muted">Giỏ hàng của bạn đang trống.</p>
    @else

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>
                            <input type="checkbox" id="select-all">
                        </th>
                        <th>Ảnh</th>
                        <th>Sản phẩm</th>
                        <th class="text-end">Đơn giá</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-end">Thành tiền</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($cartItems as $item)
                        <tr>

                            {{-- Checkbox --}}
                            <td>
                                <input
                                    type="checkbox"
                                    class="select-item"
                                    value="{{ $item->id_gh }}"
                                    data-price="{{ $item->don_gia * $item->so_luong }}"
                                >
                            </td>

                            {{-- Ảnh --}}
                            <td>
                                <img
                                    src="{{ asset($item->product->hinh_anh) }}"
                                    style="width:60px;height:60px;object-fit:cover"
                                >
                            </td>

                            {{-- Tên --}}
                            <td>
                                {{ $item->product->ten_san_pham }}
                            </td>

                            {{-- Đơn giá --}}
                            <td class="text-end">
                                {{ number_format($item->don_gia, 0, ',', '.') }} ₫
                            </td>

                            {{-- Số lượng --}}
                            <td class="text-center">
                                <form
                                    action="{{ route('client.cart.update', $item->id_gh) }}"
                                    method="POST"
                                    class="d-inline-flex"
                                >
                                    @csrf
                                    @method('PUT')

                                    <button name="action" value="decrease" class="btn btn-outline-secondary btn-sm">-</button>

                                    <input
                                        type="text"
                                        readonly
                                        value="{{ $item->so_luong }}"
                                        class="form-control form-control-sm text-center mx-1"
                                        style="width:50px"
                                    >

                                    <button name="action" value="increase" class="btn btn-outline-secondary btn-sm">+</button>
                                </form>
                            </td>

                            {{-- Thành tiền --}}
                            <td class="text-end">
                                {{ number_format($item->don_gia * $item->so_luong, 0, ',', '.') }} ₫
                            </td>

                            {{-- Xóa --}}
                            <td>
                                <form action="{{ route('client.cart.removeOne', $item->id_gh) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Xóa</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tổng tiền --}}
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h4 class="mb-0">
                Tổng tiền:
                <span id="total-price" class="text-danger fw-bold">
                    0 ₫
                </span>
            </h4>

            <div class="d-flex align-items-center gap-2">

                {{-- Form xóa nhiều --}}
                <form id="delete-multiple-form"
                      action="{{ route('client.cart.remove') }}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                </form>

                <button onclick="deleteSelected()"
                        class="btn btn-outline-danger btn-sm px-3 fw-bold rounded-pill shadow-sm">
                    🗑 Xóa đã chọn
                </button>

                <a href="{{ route('client.checkout') }}"
                   class="btn btn-primary btn-sm px-3 fw-bold rounded-pill shadow-sm">
                    🛒 Thanh toán
                </a>

            </div>
        </div>

    @endif
</div>

<script>
function formatVND(number) {
    return number.toLocaleString('vi-VN') + ' ₫';
}

function updateTotal() {
    let total = 0;

    document.querySelectorAll('.select-item:checked').forEach(function (checkbox) {
        total += parseInt(checkbox.dataset.price);
    });

    document.getElementById('total-price').innerText = formatVND(total);
}

// Tick từng item
document.querySelectorAll('.select-item').forEach(function (checkbox) {
    checkbox.addEventListener('change', updateTotal);
});

// Tick all
document.getElementById('select-all')?.addEventListener('change', function (e) {
    document.querySelectorAll('.select-item').forEach(function (checkbox) {
        checkbox.checked = e.target.checked;
    });
    updateTotal();
});

// Xóa nhiều
function deleteSelected() {
    const form = document.getElementById('delete-multiple-form');

    form.querySelectorAll('input[name="selected[]"]').forEach(i => i.remove());

    document.querySelectorAll('.select-item:checked').forEach(function (checkbox) {
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'selected[]';
        input.value = checkbox.value;
        form.appendChild(input);
    });

    if (form.querySelectorAll('input[name="selected[]"]').length === 0) {
        alert('Vui lòng chọn sản phẩm!');
        return;
    }

    form.submit();
}
</script>

@endsection