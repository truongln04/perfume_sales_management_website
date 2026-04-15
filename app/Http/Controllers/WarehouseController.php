<?php
namespace App\Http\Controllers;

use App\Models\WarehouseItem;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index() {
        $items = WarehouseItem::with('product')->get();
        return view('admin.warehouse.index', compact('items'));
    }

    public function store(Request $request) {
        // Khi thêm sản phẩm mới, tạo luôn bản ghi kho
        WarehouseItem::create([
            'id_san_pham' => $request->id_san_pham,
            'so_luong_nhap' => 0,
            'so_luong_ban' => 0
        ]);
        return redirect()->route('warehouse.index')->with('success','Kho đã được tạo cho sản phẩm');
    }


    // Tìm kiếm theo tên sản phẩm
    public function search(Request $request) {
        $keyword = $request->input('keyword');
        $items = WarehouseItem::whereHas('product', function($q) use ($keyword) {
            $q->where('ten_san_pham','like','%'.$keyword.'%');
        })->with('product')->get();

        $items = $items->map(function($item){
            return [
                'id_san_pham' => $item->id_san_pham,
                'ten_san_pham' => $item->product->ten_san_pham ?? 'N/A',
                'so_luong_nhap' => $item->so_luong_nhap,
                'so_luong_ban' => $item->so_luong_ban,
                'ton_kho_hien_tai' => $item->ton_kho_hien_tai
            ];
        });

        return response()->json($items);
    }
}
