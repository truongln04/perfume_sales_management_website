<h2>📦 Đơn hàng mới</h2>

<p>Mã đơn: #{{ $order->id_don_hang }}</p>
<p>Khách hàng: {{ $order->ho_ten_nhan }}</p>
<p>SĐT: {{ $order->sdt_nhan }}</p>
<p>Địa chỉ: {{ $order->dia_chi_giao }}</p>

<p>Tổng tiền: {{ number_format($order->tong_tien) }} ₫</p>

<p>Phương thức: {{ $order->phuong_thuc_tt }}</p>