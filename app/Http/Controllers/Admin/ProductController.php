<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    private function messages(): array
    {
        return [
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists'   => 'Danh mục không hợp lệ.',
            'name.required'        => 'Vui lòng nhập tên sản phẩm.',
            'price.required'       => 'Vui lòng nhập giá.',
            'price.numeric'        => 'Giá phải là số.',
            'price.min'            => 'Giá không được âm.',
            'stock.required'       => 'Vui lòng nhập số lượng tồn.',
            'stock.integer'        => 'Số lượng phải là số nguyên.',
            'stock.min'            => 'Số lượng không được âm.',
            'image.image'          => 'File phải là ảnh.',
            'image.max'            => 'Ảnh tối đa 2MB.',
        ];
    }

    public function index(Request $request)
    {
        $products   = $this->filteredQuery($request)->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());
        //tạo tên file không trùng + thểm ảnh vào puclic/images/img-products
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/img-products'), $name);

            $data['image'] = $name;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate($this->rules(), $this->messages());

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($product->image) {
                File::delete(public_path('images/img-products/' . $product->image));
            }

            $file = $request->file('image');
            $name = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/img-products'), $name);

            $data['image'] = $name;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            File::delete(public_path('images/img-products/' . $product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công!');
    }

    //[+] Import/Export Dữ liệu: Bổ sung tính năng xuất/nhập danh sách sản phẩm (ví dụ: qua file
    // Excel hoặc CSV) tại trang quản lý Sản phẩm của Admin.

    private function filteredQuery(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->stock_status === 'out') {
            $query->where('stock', '<=', 0);
        } elseif ($request->stock_status === 'low') {
            $query->whereBetween('stock', [1, 10]);
        } elseif ($request->stock_status === 'in') {
            $query->where('stock', '>', 10);
        }

        return $query;
    }

    public function export(Request $request)
    {
        $products = $this->filteredQuery($request)->latest()->get();
        $fileName = 'san-pham-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($products) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM để Excel đọc đúng tiếng Việt

            fputcsv($out, ['ID', 'Tên sản phẩm', 'Danh mục', 'Giá', 'Tồn kho', 'Mô tả', 'Ảnh']);

            foreach ($products as $p) {
                fputcsv($out, [
                    $p->id,
                    $p->name,
                    $p->category->name,
                    (int) $p->price,
                    $p->stock,
                    $p->description,
                    $p->image,
                ]);
            }

            fclose($out);
        }, $fileName, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
    public function template()
    {
        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Tên sản phẩm', 'Danh mục', 'Giá', 'Tồn kho', 'Mô tả']);
            fputcsv($out, ['Xe cứu hỏa mini', 'Đồ chơi xe & mô hình', 120000, 20, 'Xe cứu hỏa có đèn và còi']);
            fclose($out);
        }, 'mau-import-san-pham.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ], [
            'file.required' => 'Vui lòng chọn file CSV.',
            'file.mimes'    => 'File phải có định dạng .csv.',
            'file.max'      => 'File tối đa 5MB.',
        ]);

        $handle = fopen($request->file('file')->getRealPath(), 'r');

        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        fgetcsv($handle); // bỏ dòng tiêu đề

        $categories = Category::pluck('id', 'name');
        $added = 0;
        $errors = [];
        $line = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $line++;

            if (count(array_filter($row, fn($v) => trim((string) $v) !== '')) === 0) {
                continue;
            }

            [$name, $catName, $price, $stock, $desc] = array_pad($row, 5, null);
            $name    = trim((string) $name);
            $catName = trim((string) $catName);

            $v = Validator::make(
                ['name' => $name, 'price' => $price, 'stock' => $stock],
                ['name' => 'required|max:255', 'price' => 'required|numeric|min:0', 'stock' => 'required|integer|min:0']
            );

            if ($v->fails()) {
                $errors[] = "Dòng $line: " . $v->errors()->first();
                continue;
            }
            if (!isset($categories[$catName])) {
                $errors[] = "Dòng $line: không tìm thấy danh mục «{$catName}».";
                continue;
            }

            Product::create([
                'category_id' => $categories[$catName],
                'name'        => $name,
                'price'       => $price,
                'stock'       => $stock,
                'description' => $desc ? trim($desc) : null,
            ]);
            $added++;
        }

        fclose($handle);

        $redirect = redirect()->route('admin.products.index')
            ->with('success', "Đã nhập thành công $added sản phẩm.");

        if ($errors) {
            $redirect->with('import_errors', $errors);
        }

        return $redirect;
    }
}
