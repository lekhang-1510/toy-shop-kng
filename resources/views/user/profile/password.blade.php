@extends('layouts.user')

@section('title', 'Đổi mật khẩu')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Thông tin cá nhân</a>
                    </li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('profile.password') }}">Đổi mật
                            khẩu</a></li>
                </ul>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password.update') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label" for="current-password">Mật khẩu hiện tại</label>
                        <div class="password-field">
                            <input type="password" id="current-password" name="current_password" autocomplete="current-password"
                                class="form-control @error('current_password') is-invalid @enderror">
                            <button type="button" class="toggle-password" aria-label="Hiện mật khẩu">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="new-password">Mật khẩu mới</label>
                        <div class="password-field">
                            <input type="password" id="new-password" name="password" autocomplete="new-password"
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
                        <label class="form-label" for="password-confirmation">Xác nhận mật khẩu mới</label>
                        <div class="password-field">
                            <input type="password" id="password-confirmation" name="password_confirmation" autocomplete="new-password"
                                class="form-control">
                            <button type="button" class="toggle-password" aria-label="Hiện mật khẩu">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-toy px-4">Đổi mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection