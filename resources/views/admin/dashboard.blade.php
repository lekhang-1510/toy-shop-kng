@extends('layouts.admin')

@section('title', 'Tổng quan')
@section('page_title', 'Tổng quan')

@section('content')

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Khách hàng</div>
                    <div class="fs-3 fw-bold">{{ $stats['users'] }}</div>
                </div>
                <i class="bi bi-people stat-icon text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Danh mục</div>
                    <div class="fs-3 fw-bold">{{ $stats['categories'] }}</div>
                </div>
                <i class="bi bi-tags stat-icon text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Sản phẩm</div>
                    <div class="fs-3 fw-bold">{{ $stats['products'] }}</div>
                </div>
                <i class="bi bi-box-seam stat-icon text-warning"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Sắp hết hàng (≤ 10)</div>
                    <div class="fs-3 fw-bold">{{ $stats['low_stock'] }}</div>
                </div>
                <i class="bi bi-exclamation-triangle stat-icon text-danger"></i>
            </div>
        </div>
    </div>
</div>

<div class="card stat-card">
    <div class="card-header bg-white fw-bold">Sản phẩm mới thêm</div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestProducts as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->category->name }}</td>
                    <td>{{ number_format($p->price, 0, ',', '.') }}đ</td>
                    <td>{{ $p->stock }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Chưa có sản phẩm.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection