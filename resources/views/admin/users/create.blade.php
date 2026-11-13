@extends('layouts.admin')

@section('title', 'Thêm tài khoản')
@section('page_title', 'Thêm tài khoản')

@section('content')
<div class="card border-0 shadow-sm form-card--wide">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-full-name">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" id="user-full-name" name="full_name" value="{{ old('full_name') }}" autocomplete="off"
                        class="form-control @error('full_name') is-invalid @enderror">
                    @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-username">Tên đăng nhập <span class="text-danger">*</span></label>
                    <input type="text" id="user-username" name="username" value="{{ old('username') }}" autocomplete="off"
                        class="form-control @error('username') is-invalid @enderror">
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-email">Email <span class="text-danger">*</span></label>
                    <input type="email" id="user-email" name="email" value="{{ old('email') }}" autocomplete="off"
                        class="form-control @error('email') is-invalid @enderror">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-phone">Số điện thoại</label>
                    <input type="text" id="user-phone" name="phone" value="{{ old('phone') }}" autocomplete="off"
                        class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-password">Mật khẩu <span class="text-danger">*</span></label>
                    <div class="password-field">
                        <input type="password" id="user-password" name="password" autocomplete="new-password"
                            class="form-control @error('password') is-invalid @enderror">
                        <button type="button" class="toggle-password" aria-label="Hiện mật khẩu">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-password-confirmation">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                    <div class="password-field">
                        <input type="password" id="user-password-confirmation" name="password_confirmation" autocomplete="new-password"
                            class="form-control">
                        <button type="button" class="toggle-password" aria-label="Hiện mật khẩu">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-role">Vai trò <span class="text-danger">*</span></label>
                    <select id="user-role" name="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="user" @selected(old('role')=='user' )>User</option>
                        <option value="admin" @selected(old('role')=='admin' )>Admin</option>
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-avatar">Ảnh đại diện</label>
                    <input type="file" id="user-avatar" name="avatar" accept="image/*"
                        class="form-control @error('avatar') is-invalid @enderror">
                    @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label" for="user-address">Địa chỉ</label>
                    <input type="text" id="user-address" name="address" value="{{ old('address') }}" autocomplete="off"
                        class="form-control @error('address') is-invalid @enderror">
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                            @checked(old('is_active', true))>
                        <label class="form-check-label" for="is_active">Kích hoạt tài khoản (Active)</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-toy px-4">Lưu</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection