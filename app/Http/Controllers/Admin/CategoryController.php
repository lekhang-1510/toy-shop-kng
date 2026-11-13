<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        // Tìm kiếm theo tên hoặc mô tả
        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('name', 'like', "%{$kw}%")
                    ->orWhere('description', 'like', "%{$kw}%");
            });
        }

        // Lọc: có / chưa có sản phẩm
        if ($request->filled('has_products')) {
            if ($request->has_products === '1') {
                $query->has('products');
            } elseif ($request->has_products === '0') {
                $query->doesntHave('products');
            }
        }

        $categories = $query->latest()->paginate(10)->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'name.unique'   => 'Tên danh mục đã tồn tại.',
        ]);

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm danh mục thành công!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'name.unique'   => 'Tên danh mục đã tồn tại.',
        ]);

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(Category $category)
    {
        // Không cho xóa nếu còn sản phẩm (khóa ngoại RESTRICT)
        if ($category->products()->exists()) {
            return back()->with('error', 'Không thể xóa: danh mục này còn sản phẩm.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}
