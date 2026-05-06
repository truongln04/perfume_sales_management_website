<p>Xin chào {{ $order->ho_ten_nhan }},</p>

<p>Đơn hàng <strong>#{{ $order->id_don_hang }}</strong> của bạn đã được giao thành công.</p>

<p><strong>Tổng tiền:</strong> 
    {{ number_format($order->tong_tien,0,',','.') }} ₫
</p>

<p>Cảm ơn bạn đã mua hàng ❤️</p>