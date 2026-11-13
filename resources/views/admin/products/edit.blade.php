@extends('layouts.admin')

@section('title', 'Sửa sản phẩm')
@section('page_title', 'Sửa sản phẩm')

@section('content')
<div class="card border-0 shadow-sm form-card--wide">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label" for="product-name">Tên sản phẩm <span class="text-danger">*</span></label>
                <input type="text" id="product-name" name="name" value="{{ old('name', $product->name) }}"
                    class="form-control @error('name') is-invalid @enderror">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="product-category">Danh mục <span class="text-danger">*</span></label>
                    <select id="product-category" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        @foreach($categories as $c)
                        <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) ==
                            $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="product-price">Giá (đ) <span class="text-danger">*</span></label>
                    <input type="number" id="product-price" name="price" value="{{ old('price', (int) $product->price) }}" min="0"
                        class="form-control @error('price') is-invalid @enderror">
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="product-stock">Số lượng tồn <span class="text-danger">*</span></label>
                    <input type="number" id="product-stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                        class="form-control @error('stock') is-invalid @enderror">
                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="product-image">Hình ảnh</label>
                <div class="mb-2">
                    <img src="{{ $product->image ? asset('images/img-products/'.$product->image) : 'https://placehold.co/120x120?text=Toy' }}"
                        width="120" class="rounded border avatar-preview" alt="{{ $product->name }}">
                </div>
                <input type="file" id="product-image" name="image" accept="image/*"
                    class="form-control @error('image') is-invalid @enderror">
                <small class="text-muted">Để trống nếu không muốn đổi ảnh.</small>
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="product-description">Mô tả</label>
                <textarea id="product-description" name="description" rows="4"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-toy px-4">Cập nhật</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection