<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index() {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create() {
        return view('admin.categories.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'ten_danh_muc' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
        ]);
        Category::create($validated);
        return redirect()->route('categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit($id) {
        $dm = Category::findOrFail($id);
        return view('admin.categories.edit', compact('dm'));
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'ten_danh_muc' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
        ]);
        $dm = Category::findOrFail($id);
        $dm->update($validated);
        return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id) {
        $dm = Category::findOrFail($id);
        $dm->delete();
        return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
