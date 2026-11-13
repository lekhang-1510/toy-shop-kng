@extends('layouts.admin')

@section('title', 'Thêm danh mục')
@section('page_title', 'Thêm danh mục')

@section('content')
<div class="card border-0 shadow-sm form-card--category">
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="category-name">Tên danh mục <span class="text-danger">*</span></label>
                <input type="text" id="category-name" name="name" value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="category-description">Mô tả</label>
                <textarea id="category-description" name="description" rows="4"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-toy px-4">Lưu</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection