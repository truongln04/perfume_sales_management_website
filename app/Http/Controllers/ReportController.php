<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use DB;

class ReportController extends Controller
{
    // Trang chính index
    public function index()
    {
        return view('admin.reports.index');
    }

    // Doanh thu theo thời gian
    public function doanhThu(Request $request)
    {
        $from    = $request->input('fromDate');
        $to      = $request->input('toDate');
        $payment = $request->input('payment');

        $query = Order::select(
                DB::raw('DATE(ngay_dat) as ngay'),
                DB::raw('SUM(tong_tien) as doanhThu')
            )
            ->groupBy('ngay');

        if ($from) {
            $query->whereDate('ngay_dat', '>=', $from);
        }
        if ($to) {
            $query->whereDate('ngay_dat', '<=', $to);
        }
        if ($payment) {
            $query->where('phuong_thuc_thanh_toan', $payment);
        }

        $data = $query->get();

        // trả về partial để index load vào panel
        return view('admin.reports.partials.doanhthu', compact('data'));

    }

    // Đơn hàng theo trạng thái
    public function donHang(Request $request)
    {
        $from   = $request->input('fromDate');
        $to     = $request->input('toDate');
        $status = $request->input('orderStatus');

        $query = Order::select('trang_thai', DB::raw('COUNT(*) as soLuong'))
            ->groupBy('trang_thai');

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }
        if ($status) {
            $query->where('trang_thai', $status);
        }

        $data = $query->get();

        return view('admin.reports.partials.donhang', compact('data'));
    }

    // Tồn kho
    public function tonKho()
    {
        $products = Product::with('warehouse')->get();

        $data = $products->map(function ($p) {
            return [
                'tenSanPham'  => $p->ten_san_pham,
                'soLuongNhap' => $p->warehouse->so_luong_nhap ?? 0,
                'soLuongBan'  => $p->warehouse->so_luong_ban ?? 0,
                'tonKho'      => $p->warehouse->ton_kho_hien_tai ?? 0,
            ];
        });

        return view('admin.reports.partials.tonkho', compact('data'));
    }

    // Sản phẩm bán chạy
    public function banChay(Request $request)
    {
        $from = $request->input('fromDate');
        $to   = $request->input('toDate');
        $top  = $request->input('top', 10);

        $query = Product::select(
                'san_pham.ten_san_pham',
                DB::raw('SUM(chi_tiet_don_hang.so_luong) as tongBan')
            )
            ->join('chi_tiet_don_hang', 'chi_tiet_don_hang.id_san_pham', '=', 'san_pham.id_san_pham')
            ->join('don_hang', 'don_hang.id_don_hang', '=', 'chi_tiet_don_hang.id_don_hang')
            ->groupBy('san_pham.ten_san_pham')
            ->orderByDesc('tongBan')
            ->limit($top);

        if ($from) {
            $query->whereDate('don_hang.ngay_dat', '>=', $from);
        }
        if ($to) {
            $query->whereDate('don_hang.ngay_dat', '<=', $to);
        }

        $data = $query->get();

        return view('admin.reports.partials.banchay', compact('data'));
    }
}
