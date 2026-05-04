<?php
namespace App\Http\Controllers;
use App\Models\Acount;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /* ===========================
     * Trang chủ & sản phẩm
     * =========================== */
    public function home()
{
    $brands = Brand::all();
    $categories = Category::all();

    $productsByCategory = [];

    foreach ($categories as $cat) {
        $productsByCategory[$cat->id_danh_muc] = Product::where('id_danh_muc', $cat->id_danh_muc)
            ->where('trang_thai', 1)
            ->orderBy('id_san_pham', 'desc') 
            ->take(20)
            ->get();
    }

    return view('client.home', compact(
        'brands',
        'categories',
        'productsByCategory'
    ));
}

    public function products(Request $request) {
        $query = Product::query();
         //  Tìm kiếm theo tên
    if ($request->filled('q')) {
        $query->where('ten_san_pham', 'like', '%' . $request->q . '%');
    }

    //  Lọc theo giá 
    if ($request->price && $request->price !== 'all') {
        [$min, $max] = explode('-', $request->price);

        $query->whereBetween('gia_ban', [(int)$min, (int)$max]);
    }

    //  Nếu có trạng thái 
    $query->where('trang_thai', 1);

    //  Phân trang 
    $products = $query->paginate(12);

    //  Danh mục 
    $categories = Category::all();

    return view('client.products', compact('products', 'categories'));
    }

    public function product($id)
{
    $product = Product::with(['category','brand'])
        ->where('trang_thai', 1)
        ->findOrFail($id);

    $categories = Category::all();

    $related = Product::where('id_danh_muc', $product->id_danh_muc)
        ->where('id_san_pham', '!=', $id)
        ->where('trang_thai', 1)
        ->inRandomOrder()
        ->take(5)
        ->get();

    return view('client.product', compact(
        'product',
        'categories',
        'related'
    ));
}

    public function category($id)
{
    // Lấy danh mục hiện tại
    $category = Category::findOrFail($id);

    // Query sản phẩm
    $query = Product::where('id_danh_muc', $id);

    // Lọc theo giá 
    if (request()->price && request()->price !== 'all') {
        [$min, $max] = explode('-', request()->price);

        $query->whereBetween('gia_ban', [(int)$min, (int)$max]);
    }

    // Phân trang
    $products = $query->paginate(12);

    // Danh sách danh mục (nếu layout cần)
    $categories = Category::all();

    return view('client.category', compact(
        'products',
        'categories',
        'category' 
    ));
}

    public function brand(Request $request, $id) {
    $categories = Category::all();
    $brand      = Brand::findOrFail($id);

    $query = Product::where('id_thuong_hieu', $id);

    // Tìm kiếm 
    if ($request->filled('q')) {
        $query->where('ten_san_pham', 'like', '%' . $request->q . '%');
    }

    // Lọc giá 
    if ($request->filled('price') && $request->price != 'all') {
        [$min, $max] = explode('-', $request->price);
        $query->whereBetween('gia_ban', [$min, $max]);
    }

    $products = $query->paginate(12);

    return view('client.brand', compact('products', 'categories', 'brand'));
    }

    // /* ===========================
    //  * Giỏ hàng
    //  * =========================== */
    // public function cart()
    // {
    //     $categories = Category::all();
    //     $cartItems = session('cart', []);
    //     return view('client.cart', compact('categories','cartItems'));
    // }

    // public function addToCart(Request $request, $id)
    // {
    //     $product = Product::findOrFail($id);
    //     $cart = session()->get('cart', []);

    //     if(isset($cart[$id])) {
    //         $cart[$id]['quantity'] += $request->input('quantity',1);
    //     } else {
    //         $cart[$id] = [
    //             'ten_san_pham' => $product->ten_san_pham,
    //             'gia_ban'      => $product->gia_ban,
    //             'hinh_anh'     => $product->hinh_anh, // URL ảnh
    //             'quantity'     => $request->input('quantity',1),
    //         ];
    //     }
    //     session()->put('cart',$cart);
    //     return redirect()->route('client.cart')->with('success','Đã thêm sản phẩm vào giỏ hàng');
    // }

    // public function updateCart(Request $request, $id)
    // {
    //     $cart = session()->get('cart', []);
    //     if(isset($cart[$id])) {
    //         if($request->input('action')==='increase') {
    //             $cart[$id]['quantity']++;
    //         } elseif($request->input('action')==='decrease') {
    //             $cart[$id]['quantity'] = max(1,$cart[$id]['quantity']-1);
    //         }
    //         session()->put('cart',$cart);
    //     }
    //     return back()->with('success','Cập nhật số lượng thành công');
    // }

    // public function removeOne($id)
    // {
    //     $cart = session()->get('cart', []);
    //     unset($cart[$id]);
    //     session()->put('cart',$cart);
    //     return back()->with('success','Đã xóa sản phẩm');
    // }

    // public function removeFromCart(Request $request)
    // {
    //     $cart = session()->get('cart', []);
    //     $selected = $request->input('selected', []);
    //     foreach($selected as $id) {
    //         unset($cart[$id]);
    //     }
    //     session()->put('cart',$cart);
    //     return back()->with('success','Đã xóa sản phẩm đã chọn');
    // }

    // public function clearCart()
    // {
    //     session()->forget('cart');
    //     return back()->with('success','Đã xóa toàn bộ giỏ hàng');
    // }

   public function checkoutPage()
{
    $categories = Category::all();

    // Lấy giỏ hàng từ database thay vì session
    $cartItems = Cart::with('product')
        ->where('id_tai_khoan', auth()->id())
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()
            ->route('client.cart')
            ->with('error', 'Giỏ hàng trống');
    }

    return view(
        'client.checkout',
        compact('categories', 'cartItems')
    );
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
