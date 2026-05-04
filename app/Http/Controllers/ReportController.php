<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
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
            $query->where('phuong_thuc_tt', $payment);
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
            $query->whereDate('ngay_dat', '>=', $from);
        }
        if ($to) {
            $query->whereDate('ngay_dat', '<=', $to);
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

     // Xuất Excel Doanh thu
    public function exportDoanhThu(Request $request)
    {
        $from    = $request->input('fromDate');
        $to      = $request->input('toDate');
        $payment = $request->input('payment');

        $query = Order::select(
                DB::raw('DATE(ngay_dat) as ngay'),
                DB::raw('SUM(tong_tien) as doanhThu')
            )->groupBy('ngay');

        if ($from) $query->whereDate('ngay_dat', '>=', $from);
        if ($to)   $query->whereDate('ngay_dat', '<=', $to);
        if ($payment) $query->where('phuong_thuc_tt', $payment);

        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Ngày');
        $sheet->setCellValue('B1', 'Doanh thu');

        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue("A$row", $item->ngay);
            $sheet->setCellValue("B$row", $item->doanhThu);
            $row++;
        }

        return Response::streamDownload(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'doanh-thu.xlsx');
    }

    // Xuất Excel Đơn hàng theo trạng thái
    public function exportDonHang(Request $request)
    {
        $from   = $request->input('fromDate');
        $to     = $request->input('toDate');
        $status = $request->input('orderStatus');

        $query = Order::select('trang_thai', DB::raw('COUNT(*) as soLuong'))
            ->groupBy('trang_thai');

        if ($from) $query->whereDate('ngay_dat', '>=', $from);
        if ($to)   $query->whereDate('ngay_dat', '<=', $to);
        if ($status) $query->where('trang_thai', $status);

        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Trạng thái');
        $sheet->setCellValue('B1', 'Số lượng');

        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue("A$row", $item->trang_thai);
            $sheet->setCellValue("B$row", $item->soLuong);
            $row++;
        }

        return Response::streamDownload(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'don-hang.xlsx');
    }

    // Xuất Excel Tồn kho
    public function exportTonKho()
    {
        $products = Product::with('warehouse')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Tên sản phẩm');
        $sheet->setCellValue('B1', 'Số lượng nhập');
        $sheet->setCellValue('C1', 'Số lượng bán');
        $sheet->setCellValue('D1', 'Tồn kho hiện tại');

        $row = 2;
        foreach ($products as $p) {
            $sheet->setCellValue("A$row", $p->ten_san_pham);
            $sheet->setCellValue("B$row", $p->warehouse->so_luong_nhap ?? 0);
            $sheet->setCellValue("C$row", $p->warehouse->so_luong_ban ?? 0);
            $sheet->setCellValue("D$row", $p->warehouse->ton_kho_hien_tai ?? 0);
            $row++;
        }

        return Response::streamDownload(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'ton-kho.xlsx');
    }

    // Xuất Excel Sản phẩm bán chạy
    public function exportBanChay(Request $request)
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

        if ($from) $query->whereDate('don_hang.ngay_dat', '>=', $from);
        if ($to)   $query->whereDate('don_hang.ngay_dat', '<=', $to);

        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Tên sản phẩm');
        $sheet->setCellValue('B1', 'Tổng bán');

        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue("A$row", $item->ten_san_pham);
            $sheet->setCellValue("B$row", $item->tongBan);
            $row++;
        }

        return Response::streamDownload(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'san-pham-ban-chay.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
