@extends('layouts.user')

@section('title', $product->name)

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Sản phẩm</a></li>
        <li class="breadcrumb-item">
            <a
                href="{{ route('products.index', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a>
        </li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row g-4 mb-5">
    <div class="col-md-5">
        <img src="{{ $product->image ? asset('images/img-products/'.$product->image) : 'https://placehold.co/600x450?text=Toy' }}"
            class="img-fluid product-detail-image shadow-sm w-100" alt="{{ $product->name }}">
    </div>
    <div class="col-md-7">
        <span class="badge bg-warning text-dark">{{ $product->category->name }}</span>
        <h3 class="fw-bold mt-2">{{ $product->name }}</h3>
        <div class="price fs-3 my-3">{{ number_format($product->price, 0, ',', '.') }}đ</div>

        <p>
            Tình trạng:
            @if($product->stock > 0)
            <span class="text-success fw-semibold">Còn hàng ({{ $product->stock }})</span>
            @else
            <span class="text-danger fw-semibold">Hết hàng</span>
            @endif
        </p>

        <h6 class="fw-bold">Mô tả</h6>
        <p class="text-muted">{{ $product->description ?: 'Đang cập nhật...' }}</p>
    </div>
</div>

@if($related->count())
<h5 class="fw-bold mb-3">Sản phẩm cùng danh mục</h5>
<div class="row g-3">
    @foreach($related as $r)
    <div class="col-6 col-md-3">
        <div class="card product-card h-100">
            <a href="{{ route('products.show', $r) }}">
                <img src="{{ $r->image ? asset('images/img-products/'.$r->image) : 'https://placehold.co/400x300?text=Toy' }}"
                    class="card-img-top product-img" alt="{{ $r->name }}">
            </a>
            <div class="card-body">
                <h6 class="card-title">
                    <a href="{{ route('products.show', $r) }}" class="text-decoration-none text-dark">{{ $r->name }}</a>
                </h6>
                <div class="price">{{ number_format($r->price, 0, ',', '.') }}đ</div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection