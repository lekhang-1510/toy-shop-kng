@extends('layouts.admin')

@section('title', 'Sửa tài khoản')
@section('page_title', 'Sửa tài khoản')

@section('content')
<div class="card border-0 shadow-sm form-card--wide">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data"
            autocomplete="off">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-full-name">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" id="user-full-name" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                        autocomplete="off" class="form-control @error('full_name') is-invalid @enderror">
                    @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-username">Tên đăng nhập <span class="text-danger">*</span></label>
                    <input type="text" id="user-username" name="username" value="{{ old('username', $user->username) }}" autocomplete="off"
                        class="form-control @error('username') is-invalid @enderror">
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-email">Email <span class="text-danger">*</span></label>
                    <input type="email" id="user-email" name="email" value="{{ old('email', $user->email) }}" autocomplete="off"
                        class="form-control @error('email') is-invalid @enderror">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-phone">Số điện thoại</label>
                    <input type="text" id="user-phone" name="phone" value="{{ old('phone', $user->phone) }}" autocomplete="off"
                        class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-password">Mật khẩu mới</label>
                    <div class="password-field">
                        <input type="password" id="user-password" name="password" autocomplete="new-password"
                            class="form-control @error('password') is-invalid @enderror">
                        <button type="button" class="toggle-password" aria-label="Hiện mật khẩu">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <small class="text-muted">Để trống nếu không đổi.</small>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-password-confirmation">Xác nhận mật khẩu mới</label>
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
                    <select id="user-role" name="role" class="form-select @error('role') is-invalid @enderror" @disabled($user->id ===
                        auth()->id())>
                        <option value="user" @selected(old('role', $user->role) == 'user')>User</option>
                        <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                    </select>
                    @if($user->id === auth()->id())
                    <input type="hidden" name="role" value="admin">
                    <small class="text-muted">Bạn không thể đổi vai trò của chính mình.</small>
                    @endif
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="user-avatar">Ảnh đại diện</label>
                    <div class="mb-2">
                        <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://placehold.co/80x80?text=U' }}"
                            class="rounded-circle avatar-preview" width="80" height="80" alt="Ảnh đại diện của {{ $user->full_name }}">
                    </div>
                    <input type="file" id="user-avatar" name="avatar" accept="image/*"
                        class="form-control @error('avatar') is-invalid @enderror">
                    @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label" for="user-address">Địa chỉ</label>
                    <input type="text" id="user-address" name="address" value="{{ old('address', $user->address) }}" autocomplete="off"
                        class="form-control @error('address') is-invalid @enderror">
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @if($user->id !== auth()->id())
                <div class="col-12 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                            @checked(old('is_active', $user->is_active))>
                        <label class="form-check-label" for="is_active">Kích hoạt tài khoản (Active)</label>
                    </div>
                </div>
                @endif
            </div>

            <button type="submit" class="btn btn-toy px-4">Cập nhật</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection