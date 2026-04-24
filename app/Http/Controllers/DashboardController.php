<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Receipt;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    // Tổng số tài khoản
    $taiKhoan = User::count();

    // Tổng số sản phẩm
    $sanPham = Product::count();

    // Đơn hàng mới (chờ xác nhận)
    $donHangMoi = Order::where('trang_thai', Order::STATUS_CHO_XAC_NHAN)->count();

    // Doanh thu: tổng tiền của đơn hàng hoàn thành
    $doanhThu = Order::where('trang_thai', Order::STATUS_HOAN_THANH)->sum('tong_tien');

    return view('admin.dashboard', compact('taiKhoan','sanPham','donHangMoi','doanhThu'));

}
}
