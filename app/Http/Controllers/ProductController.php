<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;

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

    // Lọc theo danh mục (riêng hoặc kết hợp)
    if ($request->filled('id_danh_muc')) {
        $query->where('id_danh_muc', $request->id_danh_muc);
    }

    // Lọc theo thương hiệu (riêng hoặc kết hợp)
    if ($request->filled('id_thuong_hieu')) {
        $query->where('id_thuong_hieu', $request->id_thuong_hieu);
    }

    // Lọc theo trạng thái
    if ($request->filled('trang_thai')) {
        $query->where('trang_thai', $request->trang_thai);
    }

    $products = $query->paginate(15);

    $categories = Category::all();
    $brands = Brand::all();

    return view('admin.products.index', compact('products','categories','brands'));
}


    public function create() {
        $categories = Category::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        return view('admin.products.create', compact('categories','brands','suppliers'));
    }

   public function store(Request $request) {
    $request->validate([
        'ten_san_pham'   => 'required',
        'id_danh_muc'    => 'required',
        'id_thuong_hieu' => 'required',
        'id_ncc'         => 'required',
        'gia_ban'        => 'required|numeric|min:0',
    ]);

    $data = $request->all();


    if ($request->hasFile('hinh_anh')) {
        $file = $request->file('hinh_anh');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('images'), $filename);
        $data['hinh_anh'] = $filename; 
    }

    
    Product::create($data);

    return redirect()->route('products.index')->with('success','Thêm sản phẩm thành công');
}


    public function edit(Product $product) {
        $categories = Category::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        return view('admin.products.edit', compact('product','categories','brands','suppliers'));
    }

    public function update(Request $request, Product $product) {
        $request->validate([
            'ten_san_pham'   => 'required',
            'mo_ta'          => 'required',
            'id_danh_muc'    => 'required',
            'id_thuong_hieu' => 'required',
            'id_ncc'         => 'required',
            'hinh_anh'       => 'nullable|image',
            'gia_ban'        => 'required|numeric|min:0',
            'km_phan_tram'   => 'nullable|numeric|min:0|max:100',
            'trang_thai'     => 'boolean'
        ]);

        // xử lý upload ảnh nếu có
        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $product->hinh_anh = $filename;
        }

        // cập nhật các field khác
        $product->ten_san_pham   = $request->ten_san_pham;
        $product->mo_ta          = $request->mo_ta;
        $product->id_danh_muc    = $request->id_danh_muc;
        $product->id_thuong_hieu = $request->id_thuong_hieu;
        $product->id_ncc         = $request->id_ncc;
        $product->gia_ban        = $request->gia_ban;
        $product->km_phan_tram   = $request->km_phan_tram;
        $product->trang_thai     = $request->trang_thai ?? 0;

        $product->save();

        return redirect()->route('products.index')->with('success','Cập nhật sản phẩm thành công');
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index')->with('success','Xóa sản phẩm thành công');
    }

    
}
