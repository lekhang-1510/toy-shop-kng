@extends('layouts.admin')

@section('title', 'Thêm sản phẩm')
@section('page_title', 'Thêm sản phẩm')

@section('content')
<div class="card border-0 shadow-sm form-card--wide">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="product-name">Tên sản phẩm <span class="text-danger">*</span></label>
                <input type="text" id="product-name" name="name" value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="product-category">Danh mục <span class="text-danger">*</span></label>
                    <select id="product-category" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">-- Chọn --</option>
                        @foreach($categories as $c)
                        <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="product-price">Giá (đ) <span class="text-danger">*</span></label>
                    <input type="number" id="product-price" name="price" value="{{ old('price') }}" min="0"
                        class="form-control @error('price') is-invalid @enderror">
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="product-stock">Số lượng tồn <span class="text-danger">*</span></label>
                    <input type="number" id="product-stock" name="stock" value="{{ old('stock', 0) }}" min="0"
                        class="form-control @error('stock') is-invalid @enderror">
                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="product-image">Hình ảnh</label>
                <input type="file" id="product-image" name="image" accept="image/*"
                    class="form-control @error('image') is-invalid @enderror">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="product-description">Mô tả</label>
                <textarea id="product-description" name="description" rows="4"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-toy px-4">Lưu</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection