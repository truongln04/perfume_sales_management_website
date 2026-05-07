<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller {
    public function index() {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create() {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request) {
        Category::create($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit(Category $category) {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category) {
        $category->update($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(Category $category) {
        // Kiểm tra nếu có sản phẩm liên quan
        if ($category->products()->count() > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục vì đang có sản phẩm liên quan!');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
