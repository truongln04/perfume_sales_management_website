<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CartController extends Controller
{
     /* ===========================
     * Giỏ hàng
     * =========================== */
    public function cart()
    {
        $categories = Category::all();
        $cartItems = Cart::with('product')
            ->where('id_tai_khoan', auth()->id())
            ->get();

        return view('client.cart', compact('categories','cartItems'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cartItem = Cart::firstOrNew([
            'id_tai_khoan' => auth()->id(),
            'id_san_pham'  => $id,
        ]);

        // Nếu chưa có thì mặc định = 0 rồi cộng thêm
        $cartItem->so_luong = ($cartItem->so_luong ?? 0)
            + $request->input('quantity', 1);

        $cartItem->don_gia = $product->gia_ban;

        $cartItem->save();

        return redirect()
            ->route('client.cart')
            ->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
    }

    public function updateCart(Request $request, $id)
    {
        $cartItem = Cart::where('id_gh', $id)
            ->where('id_tai_khoan', auth()->id())
            ->first();

        if (!$cartItem) {
            return back()->with(
                'error',
                'Sản phẩm không tồn tại trong giỏ hàng'
            );
        }

        if ($request->input('action') === 'increase') {
            $cartItem->so_luong += 1;
        }

        if ($request->input('action') === 'decrease') {
            $cartItem->so_luong = max(
                1,
                $cartItem->so_luong - 1
            );
        }

        $cartItem->save();

        return back()->with(
            'success',
            'Cập nhật số lượng thành công'
        );
    }



    public function removeFromCart($id)
    {
        Cart::where('id_tai_khoan', auth()->id())
            ->where('id_gh', $id)
            ->delete();

        return back()->with('success','Đã xóa sản phẩm khỏi giỏ hàng');
    }

    public function clearCart()
    {
        Cart::where('id_tai_khoan', auth()->id())->delete();
        return back()->with('success','Đã xóa toàn bộ giỏ hàng');
    }
}
