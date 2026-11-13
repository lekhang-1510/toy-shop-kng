@extends('layouts.user')

@section('title', 'Thông tin cá nhân')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('profile.edit') }}">Thông tin cá
                            nhân</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('profile.password') }}">Đổi mật khẩu</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="text-center mb-4">
                        <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://placehold.co/120x120?text=Avatar' }}"
                            class="rounded-circle mb-2 avatar-preview" width="120" height="120" alt="Ảnh đại diện của {{ $user->full_name }}">
                        <label class="form-label visually-hidden" for="profile-avatar">Ảnh đại diện</label>
                        <input type="file" id="profile-avatar" name="avatar" class="form-control mt-2 @error('avatar') is-invalid @enderror"
                            accept="image/*">
                        @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="profile-username">Tên đăng nhập</label>
                            <input type="text" id="profile-username" class="form-control" value="{{ $user->username }}" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="profile-full-name">Họ và tên</label>
                            <input type="text" id="profile-full-name" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                                class="form-control @error('full_name') is-invalid @enderror">
                            @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="profile-email">Email</label>
                            <input type="email" id="profile-email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="profile-phone">Số điện thoại</label>
                            <input type="text" id="profile-phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="form-control @error('phone') is-invalid @enderror">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label" for="profile-address">Địa chỉ</label>
                            <input type="text" id="profile-address" name="address" value="{{ old('address', $user->address) }}"
                                class="form-control @error('address') is-invalid @enderror">
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-toy px-4">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection