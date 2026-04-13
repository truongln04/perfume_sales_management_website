<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
class SupplierController extends Controller
{
     public function index() {
        $suppliers = Supplier::all();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create() {
        return view('admin.suppliers.create');
    }

    public function store(Request $request) {
        $request->validate([
            'ten_ncc'=>'required',
            'dia_chi'=>'required',
            'sdt'=>'required',
            'email'=>'required|email|unique:nha_cung_cap,email',
        ]);
        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success','Thêm nhà cung cấp thành công');
    }

    public function edit(Supplier $supplier) {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier) {
        $request->validate([
            'ten_ncc'=>'required',
            'dia_chi'=>'required',
            'sdt'=>'required',
            'email'=>'required|email|unique:nha_cung_cap,email,'.$supplier->id_ncc.',id_ncc',
        ]);
        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success','Cập nhật thành công');
    }

    public function destroy(Supplier $supplier) {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success','Xóa thành công');
    }
}
