@extends('layouts.user')

@section('title', 'Sản phẩm')

@section('content')

<div class="row">
    {{-- ===== BỘ LỌC ===== --}}
    <div class="col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-funnel"></i> Bộ lọc</h6>

                <form action="{{ route('products.index') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label small" for="product-keyword">Từ khóa</label>
                        <input type="text" id="product-keyword" name="keyword" value="{{ request('keyword') }}" class="form-control"
                            placeholder="Tên sản phẩm...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small" for="product-filter-category">Danh mục</label>
                        <select id="product-filter-category" name="category" class="form-select">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories as $c)
                            <option value="{{ $c->id }}" @selected(request('category')==$c->id)>
                                {{ $c->name }} ({{ $c->products_count }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small" for="product-min-price">Khoảng giá (đ)</label>
                        <div class="input-group">
                            <input type="number" id="product-min-price" name="min_price" value="{{ request('min_price') }}"
                                class="form-control" placeholder="Từ" min="0">
                            <input type="number" id="product-max-price" name="max_price" value="{{ request('max_price') }}"
                                class="form-control" placeholder="Đến" min="0" aria-label="Giá tối đa">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small" for="product-sort">Sắp xếp</label>
                        <select id="product-sort" name="sort" class="form-select">
                            <option value="">Mới nhất</option>
                            <option value="price_asc" @selected(request('sort')=='price_asc' )>Giá tăng dần</option>
                            <option value="price_desc" @selected(request('sort')=='price_desc' )>Giá giảm dần</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-toy w-100 mb-2">Lọc</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">Xóa bộ lọc</a>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== DANH SÁCH SẢN PHẨM ===== --}}
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Tất cả sản phẩm</h4>
            <span class="text-muted">{{ $products->total() }} sản phẩm</span>
        </div>

        <div class="row g-3">
            @forelse($products as $product)
            <div class="col-6 col-md-4">
                <div class="card product-card h-100">
                    <a href="{{ route('products.show', $product) }}">
                        <img src="{{ $product->image ? asset('images/img-products/'.$product->image) : 'https://placehold.co/400x300?text=Toy' }}"
                            class="card-img-top product-img" alt="{{ $product->name }}">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted">{{ $product->category->name }}</small>
                        <h6 class="card-title mt-1">
                            <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                                {{ $product->name }}
                            </a>
                        </h6>
                        <div class="price mt-auto">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                        @if($product->stock <= 0) <small class="text-danger">Hết hàng</small>
                            @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning">Không tìm thấy sản phẩm phù hợp.</div>
            </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection