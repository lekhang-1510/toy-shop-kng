<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // ===== THÔNG TIN CÁ NHÂN =====
    public function edit()
    {
        return view('user.profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'     => 'nullable|string|max:15',
            'address'   => 'nullable|string|max:255',
            'avatar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'full_name.required' => 'Vui lòng nhập họ tên.',
            'email.required'     => 'Vui lòng nhập email.',
            'email.email'        => 'Email không hợp lệ.',
            'email.unique'       => 'Email đã được sử dụng.',
            'avatar.image'       => 'Avatar phải là file ảnh.',
            'avatar.max'         => 'Ảnh tối đa 2MB.',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    // ===== ĐỔI MẬT KHẨU =====
    public function editPassword()
    {
        return view('user.profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:6|confirmed|different:current_password',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'password.required'         => 'Vui lòng nhập mật khẩu mới.',
            'password.min'              => 'Mật khẩu mới tối thiểu 6 ký tự.',
            'password.confirmed'        => 'Mật khẩu xác nhận không khớp.',
            'password.different'        => 'Mật khẩu mới không được trùng với mật khẩu hiện tại.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        $user->update(['password' => $request->password]); // cast 'hashed' tự bcrypt

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
