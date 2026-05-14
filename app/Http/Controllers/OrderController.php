<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\WarehouseItem;
use App\Mail\OrderCompletedMail;
use App\Mail\NewOrderAdminMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /* =========================================
     * ADMIN
     * ========================================= */

    public function index(Request $request)
    {
        $query = Order::with(['taiKhoan']);

        if ($request->filled('status')) {
            $query->where('trang_thai', $request->status);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('ho_ten_nhan', 'like', "%{$keyword}%")
                  ->orWhere('sdt_nhan', 'like', "%{$keyword}%")
                  ->orWhere('id_don_hang', $keyword);
            });
        }

        $orders = $query
            ->orderByDesc('id_don_hang')
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with([
            'taiKhoan',
            'chiTietDonHang.sanPham'
        ])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);

        $statuses = Order::statusLabels();
        $paymentStatuses = Order::paymentStatusLabels();

        return view(
            'admin.orders.edit',
            compact('order', 'statuses', 'paymentStatuses')
        );
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'trang_thai'    => 'required',
            'trang_thai_tt' => 'required'
        ]);

        // 👉 Lưu trạng thái cũ
        $oldStatus = $order->trang_thai;


        $order->update([
            'trang_thai'    => $request->trang_thai,
            'trang_thai_tt' => $request->trang_thai_tt,
            'ghi_chu'       => $request->ghi_chu
        ]);

     // HOÀN THÀNH -> cộng số lượng bán
    if (
        $request->trang_thai == Order::STATUS_HOAN_THANH &&
        $oldStatus != Order::STATUS_HOAN_THANH
    ) {
        // Load chi tiết đơn hàng
    $order->load('chiTietDonHang');

    // Cập nhật kho
    foreach ($order->chiTietDonHang as $detail) {

        $warehouse = WarehouseItem::where(
            'id_san_pham',
            $detail->id_san_pham
        )->first();

        if ($warehouse) {

            // Tăng số lượng bán
            $warehouse->so_luong_ban += $detail->so_luong;

            $warehouse->save();
        }
    }
        // Gửi mail nếu chuyển sang HOÀN THÀNH
        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)
                ->send(new OrderCompletedMail($order));
        }
    }

    // TRẢ HÀNG -> trừ số lượng bán
    if (
        $request->trang_thai == Order::STATUS_TRA_HANG &&
        $oldStatus == Order::STATUS_HOAN_THANH
    ) {

        $order->load('chiTietDonHang');

        foreach ($order->chiTietDonHang as $detail) {

            $warehouse = WarehouseItem::where(
                'id_san_pham',
                $detail->id_san_pham
            )->first();

            if ($warehouse) {

                // trừ số lượng bán
                $warehouse->so_luong_ban -= $detail->so_luong;

                // tránh âm kho
                if ($warehouse->so_luong_ban < 0) {
                    $warehouse->so_luong_ban = 0;
                }

                $warehouse->save();
            }
        }
    }

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Cập nhật đơn hàng thành công');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Xóa đơn hàng thành công');
    }

    /* =========================================
     * CLIENT CHECKOUT
     * ========================================= */

    public function checkout(Request $request)
{
    $userId = Auth::id();

    // ✅ Lấy ID sản phẩm được chọn từ form
    $selectedIds = $request->selected;

    if (empty($selectedIds)) {
        return redirect()
            ->route('client.cart')
            ->with('error', 'Vui lòng chọn sản phẩm để thanh toán');
    }

    /*
    |-----------------------------------------
    | Lấy giỏ hàng THEO CHECKBOX
    |-----------------------------------------
    */
    $cartItems = Cart::with('product')
        ->where('id_tai_khoan', $userId)
        ->whereIn('id_gh', $selectedIds)
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()
            ->route('client.cart')
            ->with('error', 'Không có sản phẩm hợp lệ');
    }

    /*
    |-----------------------------------------
    | Tính tổng tiền (chỉ sản phẩm được chọn)
    |-----------------------------------------
    */
    $total = $cartItems->sum(function ($item) {
        return $item->don_gia * $item->so_luong;
    });

    /*
    |=========================================
    | COD
    |=========================================
    */
    if ($request->phuongThucTT === 'COD') {

        $order = Order::create([
            'id_tai_khoan'   => $userId,
            'ho_ten_nhan'    => $request->hoTenNhan,
            'sdt_nhan'       => $request->sdtNhan,
            'dia_chi_giao'   => $request->diaChiGiao,
            'ghi_chu'        => $request->ghiChu,
            'tong_tien'      => $total,
            'phuong_thuc_tt' => 'COD',
            'trang_thai'     => 'CHO_XAC_NHAN',
            'trang_thai_tt'  => 'CHUA_THANH_TOAN',
        ]);

        // 🚀 Gửi mail cho ADMIN khi có đơn mới
    Mail::to(config('mail.admin_email'))
    ->send(new NewOrderAdminMail($order));

        // 👉 Lưu chi tiết đơn
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'id_don_hang' => $order->id_don_hang,
                'id_san_pham' => $item->id_san_pham,
                'so_luong'    => $item->so_luong,
                'don_gia'     => $item->don_gia,
            ]);
        }

        // 👉 XÓA CHỈ SẢN PHẨM ĐÃ CHỌN
        Cart::whereIn('id_gh', $selectedIds)->delete();

        return redirect()
            ->route('client.orderslist')
            ->with('success', 'Đặt hàng thành công!');
    }

    /*
    |=========================================
    | MOMO
    |=========================================
    */
    if ($request->phuongThucTT === 'ONLINE') {

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey   = env('MOMO_ACCESS_KEY');
        $secretKey   = env('MOMO_SECRET_KEY');

        $orderId   = "DH" . time();
        $requestId = time();

        $redirectUrl = route('momo.return');
        $ipnUrl      = route('momo.return');

        $orderInfo = "Thanh toán đơn hàng";
        $amount    = (string) $total;
        $extraData = "";

        $rawHash =
            "accessKey=$accessKey" .
            "&amount=$amount" .
            "&extraData=$extraData" .
            "&ipnUrl=$ipnUrl" .
            "&orderId=$orderId" .
            "&orderInfo=$orderInfo" .
            "&partnerCode=$partnerCode" .
            "&redirectUrl=$redirectUrl" .
            "&requestId=$requestId" .
            "&requestType=payWithMethod";

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'accessKey'   => $accessKey,
            'requestId'   => $requestId,
            'amount'      => $amount,
            'orderId'     => $orderId,
            'orderInfo'   => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl'      => $ipnUrl,
            'extraData'   => $extraData,
            'requestType' => "payWithMethod",
            'signature'   => $signature
        ];

        $response = Http::post($endpoint, $data)->json();

        // 👉 Lưu session (có selectedIds)
        session([
            'pending_order' => [
                'user_id'      => $userId,
                'data'         => $request->all(),
                'total'        => $total,
                'selected_ids' => $selectedIds
            ]
        ]);

        return redirect($response['payUrl']);
    }
}

    public function momoReturn(Request $request)
    {
        /*
        |-----------------------------------------
        | Thanh toán thất bại
        |-----------------------------------------
        */
        if ($request->resultCode != 0) {
        return view('client.momo-result', [
            'success' => false,
            'message' => $request->message
        ]);
    }

    $pending = session('pending_order');

    if (!$pending) {
        return redirect()
            ->route('client.cart')
            ->with('error', 'Không tìm thấy đơn hàng tạm');
    }

    // ✅ Lấy selectedIds từ session
    $selectedIds = $pending['selected_ids'];

    $cartItems = Cart::with('product')
        ->where('id_tai_khoan', $pending['user_id'])
        ->whereIn('id_gh', $selectedIds)
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()
            ->route('client.cart')
            ->with('error', 'Giỏ hàng đang trống');
    }

    $order = Order::create([
        'id_tai_khoan'   => $pending['user_id'],
        'ho_ten_nhan'    => $pending['data']['hoTenNhan'],
        'sdt_nhan'       => $pending['data']['sdtNhan'],
        'dia_chi_giao'   => $pending['data']['diaChiGiao'],
        'ghi_chu'        => $pending['data']['ghiChu'] ?? null,
        'tong_tien'      => $pending['total'],
        'phuong_thuc_tt' => 'ONLINE',
        'trang_thai'     => 'CHO_XAC_NHAN',
        'trang_thai_tt'  => 'DA_THANH_TOAN',
    ]);

    // 🚀 Gửi mail cho ADMIN khi có đơn mới
    Mail::to(config('mail.admin_email'))
        ->send(new NewOrderAdminMail($order));

    foreach ($cartItems as $item) {
        OrderDetail::create([
            'id_don_hang' => $order->id_don_hang,
            'id_san_pham' => $item->id_san_pham,
            'so_luong'    => $item->so_luong,
            'don_gia'     => $item->don_gia,
        ]);
    }

    // 👉 XÓA CHỈ ITEM ĐÃ CHỌN
    Cart::whereIn('id_gh', $selectedIds)->delete();

    session()->forget('pending_order');

    return view('client.momo-result', [
        'success' => true,
        'order'   => $order
    ]);
}
}