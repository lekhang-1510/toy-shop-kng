<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký - Toy Shop</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400..900&display=swap" rel="stylesheet">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">

</head>

<body>
    <div class="auth-wrapper">
        <div class="card auth-card p-4">
            <div class="text-center mb-3">
                <div class="auth-logo">
                    @include('partials.brand-mark')
                </div>
                <h4 class="fw-bold mb-0">Đăng ký tài khoản</h4>
                <small class="text-muted">Tạo tài khoản để mua sắm cùng Toy Shop</small>
            </div>

            @include('partials.flash-messages')

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="register-full-name">Họ và tên</label>
                    <input type="text" id="register-full-name" name="full_name" value="{{ old('full_name') }}"
                        class="form-control @error('full_name') is-invalid @enderror">
                    @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="register-username">Tên đăng nhập</label>
                    <input type="text" id="register-username" name="username" value="{{ old('username') }}"
                        class="form-control @error('username') is-invalid @enderror">
                    @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="register-password">Mật khẩu</label>
                    <div class="password-field">
                        <input type="password" id="register-password" name="password" autocomplete="new-password"
                            class="form-control @error('password') is-invalid @enderror">
                        <button type="button" class="toggle-password" aria-label="Hiện mật khẩu">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="register-password-confirmation">Xác nhận mật khẩu</label>
                    <div class="password-field">
                        <input type="password" id="register-password-confirmation" name="password_confirmation" autocomplete="new-password"
                            class="form-control">
                        <button type="button" class="toggle-password" aria-label="Hiện mật khẩu">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-toy w-100 py-2">Đăng ký</button>
            </form>

            <div class="text-center mt-3">
                Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
            </div>
            <div class="text-center mt-2">
                <a href="{{ route('home') }}" class="text-muted small">&larr; Về trang chủ</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/password-toggle.js') }}"></script>
</body>

</html>