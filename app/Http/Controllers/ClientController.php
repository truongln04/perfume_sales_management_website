<?php
namespace App\Http\Controllers;
use App\Models\Acount;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /* ===========================
     * Trang chủ & sản phẩm
     * =========================== */
    public function home() {
        $products   = Product::orderBy('id_san_pham','desc')->take(8)->get();
        $categories = Category::all();
        $brands     = Brand::all();

        return view('client.home', compact('products','categories','brands'));
    }

    public function products(Request $request) {
        $query = Product::query();
        if ($request->filled('q')) {
            $query->where('ten_san_pham','like','%'.$request->q.'%');
        }
        $products   = $query->paginate(12);
        $categories = Category::all();

        return view('client.products', compact('products','categories'));
    }

    public function product($id) {
        $product    = Product::with(['category','brand'])->findOrFail($id);
        $categories = Category::all();

        $related = Product::where('id_danh_muc',$product->id_danh_muc)
                          ->where('id_san_pham','!=',$id)
                          ->take(5)->get();

        return view('client.product', compact('product','categories','related'));
    }

    public function category($id) {
        $products   = Product::where('id_danh_muc',$id)->paginate(12);
        $categories = Category::all();

        return view('client.category', compact('products','categories'));
    }

    /* ===========================
     * Giỏ hàng
     * =========================== */
    public function cart()
    {
        $categories = Category::all();
        $cartItems = session('cart', []);
        return view('client.cart', compact('categories','cartItems'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->input('quantity',1);
        } else {
            $cart[$id] = [
                'ten_san_pham' => $product->ten_san_pham,
                'gia_ban'      => $product->gia_ban,
                'hinh_anh'     => $product->hinh_anh, // URL ảnh
                'quantity'     => $request->input('quantity',1),
            ];
        }
        session()->put('cart',$cart);
        return redirect()->route('client.cart')->with('success','Đã thêm sản phẩm vào giỏ hàng');
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            if($request->input('action')==='increase') {
                $cart[$id]['quantity']++;
            } elseif($request->input('action')==='decrease') {
                $cart[$id]['quantity'] = max(1,$cart[$id]['quantity']-1);
            }
            session()->put('cart',$cart);
        }
        return back()->with('success','Cập nhật số lượng thành công');
    }

    public function removeOne($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart',$cart);
        return back()->with('success','Đã xóa sản phẩm');
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $selected = $request->input('selected', []);
        foreach($selected as $id) {
            unset($cart[$id]);
        }
        session()->put('cart',$cart);
        return back()->with('success','Đã xóa sản phẩm đã chọn');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success','Đã xóa toàn bộ giỏ hàng');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('client.cart')->with('error','Giỏ hàng trống');
        }
        // tạo đơn hàng ở đây...
        session()->forget('cart');
        return redirect()->route('client.orderslist')->with('success','Đặt hàng thành công');
    }

public function checkoutPage()
{
    $categories = Category::all();
    $cartItems = session('cart', []);
    return view('client.checkout', compact('categories','cartItems'));
}


    /* ===========================
     * Đơn hàng
     * =========================== */
//     public function checkout(Request $request)
// {
//     $cart = session()->get('cart', []);
//     if(empty($cart)) {
//         return redirect()->route('client.cart')->with('error','Giỏ hàng trống, không thể đặt hàng');
//     }

//     // Tạo đơn hàng mới
//     $order = new Order();
//     $order->id_tai_khoan = auth()->id();
//     $order->ngay_dat     = now();
//     $order->tong_tien    = collect($cart)->sum(fn($item) => $item['gia_ban'] * $item['quantity']);
//     $order->trang_thai   = 'CHO_XAC_NHAN';
//     $order->trang_thai_tt= 'CHUA_THANH_TOAN';
//     $order->save();

//     // Lưu chi tiết đơn hàng
//     foreach($cart as $id => $item) {
//         $order->details()->create([
//             'id_san_pham' => $id,
//             'so_luong'    => $item['quantity'],
//             'don_gia'     => $item['gia_ban'],
//             'thanh_tien'  => $item['gia_ban'] * $item['quantity'],
//         ]);
//     }

//     // Xóa giỏ hàng
//     session()->forget('cart');

//     return redirect()->route('client.orderslist')->with('success','Đặt hàng thành công');
// }


    public function orderslist(Request $request) {
        $status = $request->input('status','ALL');
        $query  = Order::where('id_tai_khoan', auth()->id());

        if($status !== 'ALL') {
            $query->where('trang_thai',$status);
        }

        $orders     = $query->get();
        $categories = Category::all();

        return view('client.orderslist', compact('orders','categories'));
    }

    public function orderShow($id) {
    $categories = Category::all();
    $order = Order::with('details.product')->findOrFail($id);
    return view('client.orders.show', compact('order','categories'));
}


    public function orderCancel($id) {
        $order = Order::where('id_tai_khoan', auth()->id())->findOrFail($id);

        if($order->trang_thai === 'CHO_XAC_NHAN') {
            $order->trang_thai = 'HUY';
            $order->save();
            return redirect()->route('client.orderslist')->with('success','Đã hủy đơn hàng');
        }
        return redirect()->route('client.orderslist')->with('error','Không thể hủy đơn hàng này');
    }

    /* ===========================
     * Tài khoản
     * =========================== */
    public function profile() {
        $categories = Category::all();
        return view('client.profile', compact('categories'));
    }

    public function updateProfile(Request $request)
{
    $user = auth()->user();

    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,'.$user->id,
        'phone'    => 'nullable|string|max:20',
        'address'  => 'nullable|string|max:255',
        'password' => 'nullable|string|min:6',
    ]);

    if(!empty($data['password'])) {
        $data['password'] = bcrypt($data['password']);
    } else {
        unset($data['password']);
    }

    $user->update($data);

    return back()->with('success','Cập nhật thông tin thành công');
}

}
