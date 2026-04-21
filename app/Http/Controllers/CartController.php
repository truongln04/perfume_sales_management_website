<?php
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ClientController extends Controller
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

        $cartItem->so_luong += $request->input('quantity', 1);
        $cartItem->don_gia   = $product->gia_ban;
        $cartItem->save();

        return redirect()->route('client.cart')->with('success','Đã thêm sản phẩm vào giỏ hàng');
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            if($request->input('action') === 'increase') {
                $cart[$id]['quantity']++;
            } elseif($request->input('action') === 'decrease') {
                $cart[$id]['quantity'] = max(1, $cart[$id]['quantity'] - 1);
            }
            session()->put('cart', $cart);
        }
        return back()->with('success','Cập nhật số lượng thành công');
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
