@extends('layouts.admin')

@section('title', 'Sản phẩm')
@section('page_title', 'Quản lý sản phẩm')

@section('content')
@if(session('import_errors'))
<div class="alert alert-warning">
    <strong>Một số dòng không nhập được:</strong>
    <ul class="mb-0">
        @foreach(session('import_errors') as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif
@error('file')
<div class="alert alert-danger">{{ $message }}</div>
@enderror

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
            <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                <input type="text" name="keyword" value="{{ request('keyword') }}"
                    class="form-control filter-control--keyword-product" placeholder="Tên sản phẩm..."
                    aria-label="Tìm tên sản phẩm">

                <select name="category" class="form-select filter-control--product-category" aria-label="Lọc theo danh mục">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(request('category')==$c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>

                <input type="number" name="min_price" value="{{ request('min_price') }}"
                    class="form-control filter-control--price" placeholder="Giá từ" min="0" aria-label="Giá tối thiểu">
                <input type="number" name="max_price" value="{{ request('max_price') }}"
                    class="form-control filter-control--price" placeholder="Giá đến" min="0" aria-label="Giá tối đa">

                <select name="stock_status" class="form-select filter-control--stock" aria-label="Lọc theo tồn kho">
                    <option value="">Mọi tồn kho</option>
                    <option value="in" @selected(request('stock_status')=='in' )>Còn nhiều (&gt;10)</option>
                    <option value="low" @selected(request('stock_status')=='low' )>Sắp hết (1-10)</option>
                    <option value="out" @selected(request('stock_status')=='out' )>Hết hàng</option>
                </select>

                <button type="submit" class="btn btn-toy"><i class="bi bi-search"></i> Tìm</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Xóa lọc</a>
            </form>

            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#importModal">
                    <i class="bi bi-file-earmark-arrow-up"></i> Nhập CSV
                </button>
                <a href="{{ route('admin.products.export', request()->query()) }}" class="btn btn-outline-success">
                    <i class="bi bi-file-earmark-arrow-down"></i> Xuất CSV
                </a>
                <a href="{{ route('admin.products.create') }}" class="btn btn-toy">
                    <i class="bi bi-plus-lg"></i> Thêm sản phẩm
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="table-column-id">#</th>
                        <th class="table-column-image">Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th class="text-center">Tồn kho</th>
                        <th class="text-end table-column-product-actions">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>
                            <img src="{{ $p->image ? asset('images/img-products/'.$p->image) : 'https://placehold.co/50x50?text=Toy' }}"
                                class="table-thumb" alt="">
                        </td>
                        <td class="fw-semibold">{{ $p->name }}</td>
                        <td>{{ $p->category->name }}</td>
                        <td>{{ number_format($p->price, 0, ',', '.') }}đ</td>
                        <td class="text-center">
                            @if($p->stock <= 0) <span class="badge bg-danger">Hết hàng</span>
                                @elseif($p->stock <= 10) <span class="badge bg-warning text-dark">{{ $p->stock }}</span>
                                    @else
                                    <span class="badge bg-success">{{ $p->stock }}</span>
                                    @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-primary"
                                aria-label="Sửa sản phẩm {{ $p->name }}">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Xóa sản phẩm «{{ $p->name }}»?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    aria-label="Xóa sản phẩm {{ $p->name }}"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Không có sản phẩm nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data"
            class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Nhập sản phẩm từ file CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <p class="small text-muted mb-2">
                    Các cột theo thứ tự: <b>Tên sản phẩm, Danh mục, Giá, Tồn kho, Mô tả</b>.
                    Tên danh mục phải trùng với danh mục đã có.
                </p>
                <a href="{{ route('admin.products.template') }}" class="small">
                    <i class="bi bi-download"></i> Tải file mẫu
                </a>
                <label class="form-label visually-hidden" for="import-file">Chọn file CSV</label>
                <input type="file" id="import-file" name="file" accept=".csv,.txt" class="form-control mt-3" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-toy">Nhập</button>
            </div>
        </form>
    </div>
</div>
@endsection