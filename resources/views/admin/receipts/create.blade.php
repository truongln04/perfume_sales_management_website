@extends('layouts.admin')
@section('title','Thêm phiếu nhập')
@section('header','Thêm phiếu nhập')

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin.receipts.store') }}" method="POST">@csrf
        <div class="mb-3">
            <label>Nhà cung cấp</label>
            <select name="id_ncc" id="supplierSelect" class="form-select" required>
                <option value="">-- Chọn nhà cung cấp --</option>
                @foreach($suppliers as $s)
                    <option value="{{ $s->id_ncc }}">{{ $s->ten_ncc }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Ngày nhập</label>
            <input type="date" name="ngay_nhap" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ghi chú</label>
            <textarea name="ghi_chu" class="form-control"></textarea>
        </div>

        <h6>Chi tiết sản phẩm nhập</h6>
        <div id="details">
            <div class="row mb-2">
                <div class="col-md-4">
                    <select name="details[0][id_san_pham]" id="productSelect0" class="form-select" required>
                        <option value="">-- Chọn sản phẩm --</option>
                    </select>
                </div>
                <div class="col-md-2"><input type="number" name="details[0][so_luong]" class="form-control" placeholder="Số lượng"></div>
                <div class="col-md-2"><input type="number" name="details[0][don_gia]" class="form-control" placeholder="Đơn giá"></div>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-success" onclick="addDetail()">+ Thêm dòng</button>

        <div class="mt-3">
            <button class="btn btn-primary">Lưu phiếu nhập</button>
            <a href="{{ route('admin.receipts.index') }}" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

<script>
let detailIndex = 1;

document.getElementById('supplierSelect').addEventListener('change', function() {
    const supplierId = this.value;
    if (!supplierId) return;

    fetch(`/suppliers/${supplierId}/products`)
        .then(res => res.json())
        .then(products => {
            const select = document.getElementById('productSelect0');
            select.innerHTML = '<option value="">-- Chọn sản phẩm --</option>';
            products.forEach(p => {
                select.innerHTML += `<option value="${p.id_san_pham}">${p.ten_san_pham}</option>`;
            });
        });
});

function addDetail(){
    const supplierId = document.getElementById('supplierSelect').value;
    if (!supplierId) {
        alert("Vui lòng chọn nhà cung cấp trước");
        return;
    }

    const html = `
    <div class="row mb-2">
        <div class="col-md-4">
            <select name="details[${detailIndex}][idSanPham]" id="productSelect${detailIndex}" class="form-select" required>
                <option value="">-- Chọn sản phẩm --</option>
            </select>
        </div>
        <div class="col-md-2"><input type="number" name="details[${detailIndex}][soLuong]" class="form-control" placeholder="Số lượng"></div>
        <div class="col-md-2"><input type="number" name="details[${detailIndex}][donGia]" class="form-control" placeholder="Đơn giá"></div>
    </div>`;
    document.getElementById('details').insertAdjacentHTML('beforeend', html);

    fetch(`/suppliers/${supplierId}/products`)
        .then(res => res.json())
        .then(products => {
            const select = document.getElementById(`productSelect${detailIndex}`);
            select.innerHTML = '<option value="">-- Chọn sản phẩm --</option>';
            products.forEach(p => {
                select.innerHTML += `<option value="${p.id_san_pham}">${p.ten_san_pham}</option>`;
            });
        });

    detailIndex++;
}
</script>
@endsection
