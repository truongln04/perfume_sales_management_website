<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Tìm theo keyword
        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where(function($q) use ($kw) {
                $q->where('ten_san_pham','like','%'.$kw.'%')
                  ->orWhere('id_san_pham','like','%'.$kw.'%');
            });
        }

        // Lọc theo danh mục
        if ($request->filled('id_danh_muc')) {
            $query->where('id_danh_muc', $request->id_danh_muc);
        }

        // Lọc theo thương hiệu
        if ($request->filled('id_thuong_hieu')) {
            $query->where('id_thuong_hieu', $request->id_thuong_hieu);
        }

        // Lọc theo trạng thái
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $products   = $query->paginate(15);
        $categories = Category::all();
        $brands     = Brand::all();

        return view('admin.products.index', compact('products','categories','brands'));
    }

    public function create() {
        $categories = Category::all();
        $brands     = Brand::all();
        $suppliers  = Supplier::all();
        return view('admin.products.create', compact('categories','brands','suppliers'));
    }

    public function store(ProductRequest $request) {
        $data = $request->validated();

        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['hinh_anh'] = $filename; 
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success','Thêm sản phẩm thành công');
    }

    public function edit(Product $product) {
        $categories = Category::all();
        $brands     = Brand::all();
        $suppliers  = Supplier::all();
        return view('admin.products.edit', compact('product','categories','brands','suppliers'));
    }

    public function update(ProductRequest $request, Product $product) {
        $data = $request->validated();

        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['hinh_anh'] = $filename;
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success','Cập nhật sản phẩm thành công');
    }

    public function destroy(Product $product) {
    // kiểm tra khóa ngoại: nếu sản phẩm đã có đơn hàng thì không cho xóa
    if ($product->orders()->count() > 0) {
        return redirect()->route('admin.products.index')
            ->with('error','Không thể xóa sản phẩm vì đang có đơn hàng liên quan');
    }

    // kiểm tra phiếu nhập: nếu sản phẩm đã có phiếu nhập thì không cho xóa
    if ($product->phieuNhaps()->count() > 0) {
        return redirect()->route('admin.products.index')
            ->with('error','Không thể xóa sản phẩm vì đang có phiếu nhập liên quan');
    }

    $product->delete();
    return redirect()->route('admin.products.index')->with('success','Xóa sản phẩm thành công');
}

}
