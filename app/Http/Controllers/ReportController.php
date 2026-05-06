<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
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
    public function tonKho(Request $request)
{
    $query = DB::table('kho as k')
        ->join('san_pham as sp', 'k.id_san_pham', '=', 'sp.id_san_pham')
        ->leftJoin('danh_muc as dm', 'sp.id_danh_muc', '=', 'dm.id_danh_muc')
        ->leftJoin('thuong_hieu as th', 'sp.id_thuong_hieu', '=', 'th.id_thuong_hieu')
        ->select(
            'sp.id_san_pham',
            'sp.ten_san_pham as tenSanPham',
            'k.so_luong_nhap as soLuongNhap',
            'k.so_luong_ban as soLuongBan',
            DB::raw('(k.so_luong_nhap - k.so_luong_ban) as tonKho'),
            'dm.ten_danh_muc',
            'th.ten_thuong_hieu'
        );

    // 🔍 Filter sản phẩm (2 chế độ)
if ($request->filled('productCode')) {

    // 👉 Ưu tiên nhập ID
    $query->where('sp.id_san_pham', $request->productCode);

} elseif ($request->filled('productSelect')) {

    // 👉 Nếu không nhập thì lấy từ dropdown
    $query->where('sp.id_san_pham', $request->productSelect);
}

    // 🔍 Filter danh mục
    if ($request->filled('categoryId')) {
        $query->where('dm.id_danh_muc', $request->categoryId);
    }

    // 🔍 Filter thương hiệu
    if ($request->filled('brandId')) {
        $query->where('th.id_thuong_hieu', $request->brandId);
    }

    // 🔽 SORT
    if ($request->sortBy == 'tonKho') {
        $query->orderByRaw('(k.so_luong_nhap - k.so_luong_ban) DESC');
    } elseif ($request->sortBy == 'soLuongNhap') {
        $query->orderBy('k.so_luong_nhap', 'DESC');
    } elseif ($request->sortBy == 'soLuongBan') {
        $query->orderBy('k.so_luong_ban', 'DESC');
    } else {
        $query->orderBy('sp.id_san_pham');
    }

    $data = $query->get();

    $products = Product::all();
    $categories = Category::all();
    $brands = DB::table('thuong_hieu')->get();

    return view(
        'admin.reports.partials.tonkho',
        compact('data', 'products', 'categories', 'brands')
    );
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
    public function exportTonKho(Request $request)
{
    // 👉 Query giống hệt tonKho()
    $query = DB::table('kho as k')
        ->join('san_pham as sp', 'k.id_san_pham', '=', 'sp.id_san_pham')
        ->leftJoin('danh_muc as dm', 'sp.id_danh_muc', '=', 'dm.id_danh_muc')
        ->leftJoin('thuong_hieu as th', 'sp.id_thuong_hieu', '=', 'th.id_thuong_hieu')
        ->select(
            'sp.id_san_pham',
            'sp.ten_san_pham',
            'k.so_luong_nhap',
            'k.so_luong_ban',
            DB::raw('(k.so_luong_nhap - k.so_luong_ban) as ton_kho'),
            'dm.ten_danh_muc',
            'th.ten_thuong_hieu'
        );

    // 🔍 Filter sản phẩm (2 chế độ)
    if ($request->filled('productCode')) {
        $query->where('sp.id_san_pham', $request->productCode);
    } elseif ($request->filled('productSelect')) {
        $query->where('sp.id_san_pham', $request->productSelect);
    }

    // 🔍 Filter danh mục
    if ($request->filled('categoryId')) {
        $query->where('dm.id_danh_muc', $request->categoryId);
    }

    // 🔍 Filter thương hiệu
    if ($request->filled('brandId')) {
        $query->where('th.id_thuong_hieu', $request->brandId);
    }

    // 🔽 SORT
    if ($request->sortBy == 'tonKho') {
        $query->orderByRaw('(k.so_luong_nhap - k.so_luong_ban) DESC');
    } elseif ($request->sortBy == 'soLuongNhap') {
        $query->orderBy('k.so_luong_nhap', 'DESC');
    } elseif ($request->sortBy == 'soLuongBan') {
        $query->orderBy('k.so_luong_ban', 'DESC');
    } else {
        $query->orderBy('sp.id_san_pham');
    }

    $data = $query->get();

    /*
    |-----------------------------------------
    | Tạo Excel
    |-----------------------------------------
    */
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->setCellValue('A1', 'ID sản phẩm');
    $sheet->setCellValue('B1', 'Tên sản phẩm');
    $sheet->setCellValue('C1', 'Danh mục');
    $sheet->setCellValue('D1', 'Thương hiệu');
    $sheet->setCellValue('E1', 'Số lượng nhập');
    $sheet->setCellValue('F1', 'Số lượng bán');
    $sheet->setCellValue('G1', 'Tồn kho');

    // Data
    $row = 2;
    foreach ($data as $item) {
        $sheet->setCellValue("A$row", $item->id_san_pham);
        $sheet->setCellValue("B$row", $item->ten_san_pham);
        $sheet->setCellValue("C$row", $item->ten_danh_muc);
        $sheet->setCellValue("D$row", $item->ten_thuong_hieu);
        $sheet->setCellValue("E$row", $item->so_luong_nhap);
        $sheet->setCellValue("F$row", $item->so_luong_ban);
        $sheet->setCellValue("G$row", $item->ton_kho);
        $row++;
    }

    return Response::streamDownload(function () use ($spreadsheet) {
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
