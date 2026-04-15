<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $request->validate([
            'ten_thuong_hieu' => 'required',
            'quoc_gia'       => 'required',
            'logo'           => 'nullable',
            'logo_file'      => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = [
            'ten_thuong_hieu' => $request->ten_thuong_hieu,
            'quoc_gia'        => $request->quoc_gia,
        ];

        // Nếu upload file
        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('brands', 'public');
            $data['logo'] = asset('storage/' . $path);
        }
        // Nếu nhập URL
        elseif ($request->logo) {
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

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'ten_thuong_hieu' => 'required',
            'quoc_gia'       => 'required',
            'logo'           => 'nullable',
            'logo_file'      => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = [
            'ten_thuong_hieu' => $request->ten_thuong_hieu,
            'quoc_gia'        => $request->quoc_gia,
        ];

        // Nếu upload file mới
        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('brands', 'public');
            $data['logo'] = asset('storage/' . $path);
        }
        // Nếu nhập URL
        elseif ($request->logo) {
            $data['logo'] = $request->logo;
        }

        $brand->update($data);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Cập nhật thương hiệu thành công');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Xóa thương hiệu thành công');
    }
}