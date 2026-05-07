<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Product;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where('ten_ncc','like','%'.$kw.'%')
                  ->orWhere('email','like','%'.$kw.'%')
                  ->orWhere('sdt','like','%'.$kw.'%');
        }

        $suppliers = $query->paginate(10);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create() {
        return view('admin.suppliers.create');
    }

    public function store(SupplierRequest $request) {
        Supplier::create($request->validated());
        return redirect()->route('admin.suppliers.index')->with('success','Thêm nhà cung cấp thành công');
    }

    public function edit(Supplier $supplier) {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, Supplier $supplier) {
        $supplier->update($request->validated());
        return redirect()->route('admin.suppliers.index')->with('success','Cập nhật thành công');
    }

    public function destroy(Supplier $supplier) {
        // kiểm tra nếu còn sản phẩm liên quan thì không cho xóa
        if ($supplier->products()->count() > 0) {
            return redirect()->route('admin.suppliers.index')
                ->with('error','Không thể xóa nhà cung cấp vì còn sản phẩm liên quan');
        }

        $supplier->delete();
        return redirect()->route('admin.suppliers.index')->with('success','Xóa thành công');
    }

    public function getProducts($id)
    {
        $products = Product::where('id_ncc', $id)
            ->get(['id_san_pham','ten_san_pham']);
        return response()->json($products);
    }
}
