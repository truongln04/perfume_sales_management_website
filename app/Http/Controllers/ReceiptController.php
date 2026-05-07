<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Receipt;
use App\Models\ReceiptDetail;
use App\Models\Supplier;
use App\Models\Product;
use App\Http\Requests\ReceiptRequest; // dùng request riêng

class ReceiptController extends Controller
{
    public function index(Request $request) {
        $query = Receipt::with('supplier');

        if ($request->filled('search')) {
            $kw = $request->search;
            $query->where(function($q) use ($kw) {
                $q->where('id_phieu_nhap','like','%'.$kw.'%')
                  ->orWhere('ghi_chu','like','%'.$kw.'%');
            });
        }

        $receipts = $query->paginate(10);
        return view('admin.receipts.index', compact('receipts'));
    }

    public function create() {
        $suppliers = Supplier::all();
        $products  = Product::all();
        return view('admin.receipts.create', compact('suppliers','products'));
    }

    public function store(ReceiptRequest $request) {
        $receipt = Receipt::create([
            // 'id_ncc'    => $request->id_ncc,
            'ngay_nhap' => $request->ngay_nhap,
            'ghi_chu'   => $request->ghi_chu,
            'tong_tien' => 0
        ]);

        $tong = 0;
        foreach ($request->details as $d) {
            $ct = new ReceiptDetail([
                'id_san_pham' => $d['id_san_pham'],
                'so_luong'    => $d['so_luong'],
                'don_gia'     => $d['don_gia']
            ]);
            $receipt->receiptDetails()->save($ct);

            // Cập nhật kho
            $warehouseItem = \App\Models\WarehouseItem::where('id_san_pham', $d['id_san_pham'])->first();
            if ($warehouseItem) {
                $warehouseItem->so_luong_nhap += $d['so_luong'];
                $warehouseItem->save();
            }

            $tong += $d['so_luong'] * $d['don_gia'];
        }

        $receipt->update(['tong_tien' => $tong]);

        return redirect()->route('admin.receipts.index')->with('success','Thêm phiếu nhập thành công');
    }

    public function show(Receipt $receipt) {
        $receipt->load('receiptDetails.product.supplier');
        return view('admin.receipts.show', compact('receipt'));
    }

    public function destroy(Receipt $receipt) {
        foreach ($receipt->receiptDetails as $detail) {
            $warehouseItem = \App\Models\WarehouseItem::where('id_san_pham', $detail->id_san_pham)->first();
            if ($warehouseItem) {
                $warehouseItem->so_luong_nhap -= $detail->so_luong;
                if ($warehouseItem->so_luong_nhap < 0) $warehouseItem->so_luong_nhap = 0;
                $warehouseItem->save();
            }
        }

        $receipt->receiptDetails()->delete();
        $receipt->delete();

        return redirect()->route('admin.receipts.index')->with('success','Xóa phiếu nhập thành công');
    }
}
