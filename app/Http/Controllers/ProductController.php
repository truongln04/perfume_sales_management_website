<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::query();

    if ($request->search) {
        $query->where('tenSanPham', 'like', '%' . $request->search . '%');
    }

    $products = $query->paginate(20);

    $danhMucs = DanhMuc::all();
    $thuongHieus = ThuongHieu::all();
    $nhaCungCaps = NhaCungCap::all();

    return view('admin.products.index', compact(
        'products',
        'danhMucs',
        'thuongHieus',
        'nhaCungCaps'
    ));
}
}
