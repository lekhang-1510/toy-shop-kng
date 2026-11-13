@extends('layouts.user')

@section('title', 'Trang chủ')

{{-- ===== BANNER FULL CHIỀU NGANG (nằm ngoài container) ===== --}}
@section('hero')
<div id="homeHero" class="carousel slide toy-hero" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators start-50 translate-middle-x justify-content-center">
        <button type="button" data-bs-target="#homeHero" data-bs-slide-to="0" class="active" aria-current="true"
            aria-label="Banner 1"></button>
        <button type="button" data-bs-target="#homeHero" data-bs-slide-to="1" aria-label="Banner 2"></button>
        <button type="button" data-bs-target="#homeHero" data-bs-slide-to="2" aria-label="Banner 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active hero-slide-1">
            <img src="{{ asset('images/img-page/baner-1.avif') }}" class="hero-image" alt="Đồ chơi sáng tạo cho bé">
            <div class="hero-overlay"></div>
            <div class="hero-copy">
                <span class="hero-badge">Mỗi ngày thêm khám phá</span>
                <h1>Thế giới đồ chơi sáng tạo</h1>
                <p class="lead my-3">Đồ chơi an toàn, khơi nguồn trí tưởng tượng và giúp bé phát triển mỗi ngày.</p>
                <a href="{{ route('products.index') }}" class="btn btn-toy px-4 py-2">
                    Khám phá ngay <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="carousel-item hero-slide-2">
            <img src="{{ asset('images/img-page/baner-2.avif') }}" class="hero-image"
                alt="Bộ đồ chơi lắp ráp nhiều màu sắc">
            <div class="hero-overlay"></div>
            <div class="hero-copy">
                <span class="hero-badge">Chơi vui, học điều hay</span>
                <h1>Xếp hình &amp; đồ chơi STEM</h1>
                <p class="lead my-3">Cùng bé lắp ghép ý tưởng và tự tin khám phá thế giới xung quanh.</p>
                <a href="{{ route('products.index') }}" class="btn btn-toy px-4 py-2">
                    Tìm đồ chơi cho bé <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="carousel-item hero-slide-3">
            <img src="{{ asset('images/img-page/baner-3.avif') }}" class="hero-image"
                alt="Đồ chơi vận động dành cho trẻ em">
            <div class="hero-overlay"></div>
            <div class="hero-copy">
                <span class="hero-badge">Niềm vui trong từng món quà</span>
                <h1>Chơi vui, lớn khôn mỗi ngày</h1>
                <p class="lead my-3">Chọn người bạn đồng hành thật đặc biệt cho bé yêu.</p>
                <a href="{{ route('products.index') }}" class="btn btn-toy px-4 py-2">
                    Xem sản phẩm <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeHero" data-bs-slide="prev">
        <span class="hero-control-icon" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
        <span class="visually-hidden">Trước</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeHero" data-bs-slide="next">
        <span class="hero-control-icon" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
        <span class="visually-hidden">Tiếp theo</span>
    </button>
</div>
@endsection

{{-- ===== NỘI DUNG TRONG CONTAINER ===== --}}
@section('content')

<section id="categories" class="home-section">
    <div class="section-heading">
        <div>
            <h2>Danh mục sản phẩm</h2>
            <p>Lựa chọn món đồ chơi phù hợp với sở thích của bé</p>
        </div>
    </div>
    <div class="category-grid mb-5">
        @foreach($categories as $category)
        <a href="{{ route('products.index', ['category' => $category->id]) }}" class="category-box">
            <div class="category-icon icon-{{ $loop->index % 5 }}">
                <i class="bi {{ $category->icon }}"></i>
            </div>
            <div class="fw-semibold mt-3">{{ $category->name }}</div>
            <small class="text-muted">{{ $category->products_count }} sản phẩm</small>
        </a>
        @endforeach
    </div>
</section>

<section id="featured" class="home-section">
    <div class="section-heading">
        <div>
            <h2>Sản phẩm mới</h2>
            <p>Những món đồ chơi mới nhất vừa có tại Toy Shop KNG</p>
        </div>
        <a href="{{ route('products.index') }}" class="section-link">
            Xem tất cả <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="row g-3 featured-grid">
        @forelse($latestProducts as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card product-card h-100">
                <a href="{{ route('products.show', $product) }}" class="product-image-link">
                    <span class="product-ribbon">Mới</span>
                    <img src="{{ $product->image ? asset('images/img-products/'.$product->image) : 'https://placehold.co/400x300?text=Toy' }}"
                        class="card-img-top product-img" alt="{{ $product->name }}">
                </a>
                <div class="card-body d-flex flex-column">
                    <small class="product-category">{{ $product->category->name }}</small>
                    <h6 class="card-title mt-1">
                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                            {{ $product->name }}
                        </a>
                    </h6>
                    <div class="price mt-auto">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                </div>
            </div>
        </div>
        @empty
        <p class="text-muted">Chưa có sản phẩm nào.</p>
        @endforelse
    </div>
</section>

@endsection