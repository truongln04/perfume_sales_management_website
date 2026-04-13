<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index() {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    public function create() {
        return view('admin.brands.create');
    }

    public function store(Request $request) {
        $request->validate([
            'ten_thuong_hieu'=>'required',
            'quoc_gia'=>'required',
            'logo'=>'nullable',
        ]);
        Brand::create($request->all());
        return redirect()->route('brands.index')->with('success','Thêm thương hiệu thành công');
    }

    public function edit(Brand $brand) {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand) {
        $request->validate([
            'ten_thuong_hieu'=>'required',
            'quoc_gia'=>'required',
            'logo'=>'nullable',
        ]);
        $brand->update($request->all());
        return redirect()->route('admin.brands.index')->with('success','Cập nhật thương hiệu thành công');
    }

    public function destroy(Brand $brand) {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success','Xóa thương hiệu thành công');
    }
}
