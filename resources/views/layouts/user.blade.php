<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Toy Shop KNG') - Cửa hàng đồ chơi trẻ em KNG</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400..900&display=swap" rel="stylesheet">

    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>

    <div class="announcement-bar">
        <div class="container"> 🚖 Đồ chơi an toàn, khơi nguồn sáng tạo và niềm vui cho bé mỗi ngày</div>
    </div>

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar navbar-expand-xl navbar-toy sticky-top shadow-sm">
        <div class="navbar-shell">
            <div class="container d-flex flex-wrap align-items-center flex-xl-nowrap">
                <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                    <span class="brand-icon">
                        @include('partials.brand-mark')
                    </span>
                    <span class="brand-copy">
                        <span class="brand-name">Toy Shop <span>KNG</span></span>
                        <small>Kids &amp; Toys</small>
                    </span>
                </a>
                <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
                    aria-label="Mở hoặc đóng menu" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="nav">
                    <ul class="navbar-nav main-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}#categories">Danh mục sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}#featured">Sản phẩm mới</a>
                        </li>
                        <li class="nav-item">
                            {{-- Tạm cuộn xuống footer, sau này đổi thành route trang thông tin cửa hàng --}}
                            <a class="nav-link" href="{{ route('about') }}">Thông tin cửa hàng</a>
                        </li>
                        <li class="nav-item">
                            {{-- Tạm cuộn xuống footer, sau này đổi thành route trang liên hệ --}}
                            <a class="nav-link" href="{{ route('contact') }}">Liên hệ</a>
                        </li>
                    </ul>

                    {{-- THANH TÌM KIẾM --}}
                    <form action="{{ route('products.index') }}" method="GET" class="nav-search ms-xl-auto my-2 my-xl-0"
                        role="search">
                        <div class="input-group">
                            <input type="search" name="keyword" value="{{ request('keyword') }}" class="form-control"
                                placeholder="Tìm đồ chơi cho bé..." aria-label="Tìm kiếm">
                            <button class="btn btn-primary bg-primary text-white" type="submit" aria-label="Tìm">
                                <i class="bi bi-search text-white"></i>
                            </button>
                        </div>
                    </form>

                    <ul class="navbar-nav account-actions gap-2">
                        <li class="nav-item">
                            <span class="cart-icon-btn" aria-disabled="true" aria-label="Giỏ hàng chưa khả dụng"
                                title="Giỏ hàng">
                                <i class="bi bi-cart3"></i>
                            </span>
                        </li>
                        @guest
                        <li class="nav-item">
                            <a class="btn btn-toy rounded-pill px-4 py-2" href="{{ route('login') }}">Đăng nhập</a>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle account-toggle" href="#" data-bs-toggle="dropdown">
                                <span
                                    class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center me-1 p-2">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                {{ auth()->user()->full_name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i> Trang quản trị</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person"></i> Thông tin cá nhân</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.password') }}">
                                        <i class="bi bi-key"></i> Đổi mật khẩu</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
            <form action="{{ route('products.index') }}" method="GET"
                class="nav-search mobile-search d-md-none container w-100" role="search">
                <div class="input-group">
                    <input type="search" name="keyword" value="{{ request('keyword') }}" class="form-control"
                        placeholder="Tìm kiếm đồ chơi cho bé..." aria-label="Tìm kiếm">
                    <button class="btn btn-primary bg-primary text-white" type="submit" aria-label="Tìm">
                        <i class="bi bi-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </nav>
    {{-- Vùng banner tràn full chiều ngang (tùy trang) --}}
    @yield('hero')

    {{-- ===== THÔNG BÁO ===== --}}
    <div class="container mt-3">
        @include('partials.flash-messages')
    </div>

    {{-- ===== NỘI DUNG ===== --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="py-4 mt-5" id="site-footer">
        <div class="container">
            <div class="footer-main py-3">
                {{-- Khối trái: logo --}}
                <div class="footer-about">
                    <div class="footer-brand mb-3">
                        <span class="brand-icon">
                            @include('partials.brand-mark')
                        </span>
                        <span class="brand-copy">
                            <span class="brand-name">Toy Shop <span>KNG</span></span>
                            <small>Kids &amp; Toys</small>
                        </span>
                    </div>
                    <p class="mb-0">Nơi mỗi món đồ chơi là một người bạn nhỏ, đồng hành cùng bé khám phá và lớn khôn.
                    </p>
                </div>

                {{-- Khối phải: 3 mục chia đều --}}
                <div class="footer-links">
                    <div>
                        <h6 class="footer-heading">Khám phá</h6>
                        <a class="footer-link" href="{{ route('home') }}">Trang chủ</a>
                        <a class="footer-link" href="{{ route('products.index') }}">Tất cả sản phẩm</a>
                    </div>
                    <div>
                        <h6 class="footer-heading">Cửa hàng</h6>
                        <a class="footer-link" href="{{ route('about') }}">Thông tin cửa hàng</a>
                        <a class="footer-link" href="{{ route('contact') }}">Liên hệ</a>
                    </div>
                    <div>
                        <h6 class="footer-heading">Tài khoản</h6>
                        @guest
                        <a class="footer-link" href="{{ route('login') }}">Đăng nhập</a>
                        <a class="footer-link" href="{{ route('register') }}">Đăng ký</a>
                        @else
                        <a class="footer-link" href="{{ route('profile.edit') }}">Thông tin cá nhân</a>
                        <a class="footer-link" href="{{ route('profile.password') }}">Đổi mật khẩu</a>
                        @endguest
                    </div>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <small>&copy; {{ date('Y') }} Toy Shop KNG. Khơi nguồn sáng tạo, kiến tạo tương lai.</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/password-toggle.js') }}"></script>
    @stack('scripts')
</body>

</html>