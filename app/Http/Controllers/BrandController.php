<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Http\Requests\BrandRequest;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request)
    {
        $data = [
            'ten_thuong_hieu' => $request->ten_thuong_hieu,
            'quoc_gia'        => $request->quoc_gia,
        ];

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('brands', 'public');
            $data['logo'] = asset('storage/' . $path);
        } elseif ($request->logo) {
            $data['logo'] = $request->logo;
        }

        Brand::create($data);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Thêm thương hiệu thành công');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $data = [
            'ten_thuong_hieu' => $request->ten_thuong_hieu,
            'quoc_gia'        => $request->quoc_gia,
        ];

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('brands', 'public');
            $data['logo'] = asset('storage/' . $path);
        } elseif ($request->logo) {
            $data['logo'] = $request->logo;
        }

        $brand->update($data);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Cập nhật thương hiệu thành công');
    }

    public function destroy(Brand $brand)
{
    // Kiểm tra nếu thương hiệu có sản phẩm liên quan
    if ($brand->products()->count() > 0) {
        return redirect()
            ->route('admin.brands.index')
            ->with('error', 'Không thể xóa thương hiệu vì đang có sản phẩm liên quan!');
    }

    $brand->delete();
    return redirect()
        ->route('admin.brands.index')
        ->with('success', 'Xóa thương hiệu thành công');
}

}
