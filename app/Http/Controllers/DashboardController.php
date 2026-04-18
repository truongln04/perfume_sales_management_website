<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    

    // Trang Blade cho admin
    public function index()
    {
        $taiKhoan   = User::count();
        $sanPham    = Product::count();
        $donHangMoi = Order::where('trang_thai', 'moi')->count();
        $doanhThu   = Order::where('trang_thai', 'hoan_thanh')->sum('tong_tien');

        return view('admin.dashboard.index', compact(
            'taiKhoan','sanPham','donHangMoi','doanhThu'
        ));
    }
}
