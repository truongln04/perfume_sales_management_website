<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
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

        $orders = $query->orderByDesc('id_don_hang')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['taiKhoan', 'chiTietDonHang.sanPham'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $statuses = Order::statusLabels();
        $paymentStatuses = Order::paymentStatusLabels();
        return view('admin.orders.edit', compact('order', 'statuses', 'paymentStatuses'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'trang_thai' => 'required',
            'trang_thai_tt' => 'required'
        ]);

        $order->update([
            'trang_thai' => $request->trang_thai,
            'trang_thai_tt' => $request->trang_thai_tt,
            'ghi_chu' => $request->ghi_chu
        ]);

        return redirect()->route('orders.index')->with('success', 'Cập nhật đơn hàng thành công');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Xóa đơn hàng thành công');
    }
}
