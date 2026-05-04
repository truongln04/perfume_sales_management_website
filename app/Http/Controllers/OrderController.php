<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

        $order->update([
            'trang_thai'    => $request->trang_thai,
            'trang_thai_tt' => $request->trang_thai_tt,
            'ghi_chu'       => $request->ghi_chu
        ]);

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

        /*
        |-----------------------------------------
        | Lấy giỏ hàng từ DATABASE (không dùng session)
        |-----------------------------------------
        */
        $cartItems = Cart::with('product')
            ->where('id_tai_khoan', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('client.cart')
                ->with('error', 'Giỏ hàng đang trống');
        }

        /*
        |-----------------------------------------
        | Tính tổng tiền
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

            /*
            |-----------------------------------------
            | Lưu chi tiết đơn hàng
            |-----------------------------------------
            */
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'id_don_hang' => $order->id_don_hang,
                    'id_san_pham' => $item->id_san_pham,
                    'so_luong'    => $item->so_luong,
                    'don_gia'     => $item->don_gia,
                ]);
            }

            /*
            |-----------------------------------------
            | Xóa giỏ hàng trong DB sau khi đặt thành công
            |-----------------------------------------
            */
            Cart::where('id_tai_khoan', $userId)->delete();

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

            $signature = hash_hmac(
                "sha256",
                $rawHash,
                $secretKey
            );

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

            /*
            |-----------------------------------------
            | Lưu đơn tạm
            |-----------------------------------------
            */
            session([
                'pending_order' => [
                    'user_id' => $userId,
                    'data'    => $request->all(),
                    'total'   => $total
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

        /*
        |-----------------------------------------
        | Lấy giỏ hàng từ DB
        |-----------------------------------------
        */
        $cartItems = Cart::with('product')
            ->where('id_tai_khoan', $pending['user_id'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('client.cart')
                ->with('error', 'Giỏ hàng đang trống');
        }

        /*
        |-----------------------------------------
        | Tạo đơn hàng
        |-----------------------------------------
        */
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

        /*
        |-----------------------------------------
        | Lưu chi tiết đơn hàng
        |-----------------------------------------
        */
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'id_don_hang' => $order->id_don_hang,
                'id_san_pham' => $item->id_san_pham,
                'so_luong'    => $item->so_luong,
                'don_gia'     => $item->don_gia,
            ]);
        }

        /*
        |-----------------------------------------
        | Xóa giỏ hàng sau thanh toán thành công
        |-----------------------------------------
        */
        Cart::where(
            'id_tai_khoan',
            $pending['user_id']
        )->delete();

        session()->forget('pending_order');

        return view('client.momo-result', [
            'success' => true,
            'order'   => $order
        ]);
    }
}