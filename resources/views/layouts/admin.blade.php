<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quản trị') - Toy Shop Admin</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400..900&display=swap" rel="stylesheet">

    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>

    {{-- ===== SIDEBAR ===== --}}
    <aside class="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            @include('partials.brand-mark')
            <span>Toy Shop <span class="text-info">KNG</span></span>
        </a>
        <ul class="nav flex-column mt-2">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Tổng quan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                    href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i> Tài khoản
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                    href="{{ route('admin.categories.index') }}">
                    <i class="bi bi-tags"></i> Danh mục
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                    href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box-seam"></i> Sản phẩm
                </a>
            </li>
            <li class="nav-item mt-3">
                <a class="nav-link" href="{{ route('home') }}" target="_blank">
                    <i class="bi bi-shop"></i> Xem trang web
                </a>
            </li>
        </ul>
    </aside>

    {{-- ===== PHẦN CHÍNH ===== --}}
    <div class="admin-main">
        <div class="admin-topbar d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@yield('page_title', 'Quản trị')</h5>
            <div class="dropdown">
                <a href="#" class="text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i> {{ auth()->user()->full_name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right"></i> Đăng xuất
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="admin-content">
            @include('partials.flash-messages')

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/password-toggle.js') }}"></script>
    @stack('scripts')
</body>

</html>