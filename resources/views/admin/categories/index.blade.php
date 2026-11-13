@extends('layouts.admin')

@section('title', 'Danh mục')
@section('page_title', 'Quản lý danh mục')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
            {{-- Lọc & tìm kiếm --}}
            <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                <input type="text" name="keyword" value="{{ request('keyword') }}"
                    class="form-control filter-control--keyword-category" placeholder="Tìm tên / mô tả..."
                    aria-label="Tìm tên hoặc mô tả danh mục">
                <select name="has_products" class="form-select filter-control--category"
                    aria-label="Lọc danh mục theo số sản phẩm">
                    <option value="">Tất cả</option>
                    <option value="1" @selected(request('has_products')==='1' )>Có sản phẩm</option>
                    <option value="0" @selected(request('has_products')==='0' )>Chưa có sản phẩm</option>
                </select>
                <button type="submit" class="btn btn-toy"><i class="bi bi-search"></i> Tìm</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Xóa lọc</a>
            </form>

            <a href="{{ route('admin.categories.create') }}" class="btn btn-toy">
                <i class="bi bi-plus-lg"></i> Thêm danh mục
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="table-column-id">#</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th class="text-center">Số sản phẩm</th>
                        <th class="text-end table-column-category-actions">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td class="fw-semibold">{{ $c->name }}</td>
                        <td class="text-muted">{{ \Illuminate\Support\Str::limit($c->description, 60) }}</td>
                        <td class="text-center"><span class="badge bg-info text-dark">{{ $c->products_count }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $c) }}" class="btn btn-sm btn-outline-primary"
                                aria-label="Sửa danh mục {{ $c->name }}">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $c) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Xóa danh mục «{{ $c->name }}»?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    aria-label="Xóa danh mục {{ $c->name }}"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Không có danh mục nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection