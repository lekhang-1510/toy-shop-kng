<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Tìm kiếm theo họ tên, tên đăng nhập, email
        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('full_name', 'like', "%{$kw}%")
                    ->orWhere('username', 'like', "%{$kw}%")
                    ->orWhere('email', 'like', "%{$kw}%");
            });
        }

        // Lọc theo vai trò
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:100|alpha_dash|unique:users,username',
            'email'     => 'required|email|max:255|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
            'role'      => 'required|in:user,admin',
            'phone'     => 'nullable|string|max:15',
            'address'   => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'avatar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], $this->messages());

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data); // password tự bcrypt nhờ cast 'hashed'

        return redirect()->route('admin.users.index')
            ->with('success', 'Thêm tài khoản thành công!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => ['required', 'string', 'max:100', 'alpha_dash', Rule::unique('users', 'username')->ignore($user->id)],
            'email'     => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password'  => 'nullable|string|min:6|confirmed',
            'role'      => 'required|in:user,admin',
            'phone'     => 'nullable|string|max:15',
            'address'   => 'nullable|string|max:255',
            'avatar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], $this->messages());

        // Không cho admin tự hạ quyền / tự khóa chính mình
        if ($user->id === Auth::id()) {
            $data['role'] = 'admin';
            $data['is_active'] = true;
        } else {
            $data['is_active'] = $request->boolean('is_active');
        }

        // Để trống mật khẩu = giữ nguyên
        if (empty($data['password'])) {
            unset($data['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Cập nhật tài khoản thành công!');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Bạn không thể xóa chính mình.');
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Xóa tài khoản thành công!');
    }

    // Bật / tắt trạng thái (vô hiệu hóa)
    public function toggle(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Bạn không thể vô hiệu hóa chính mình.');
        }

        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', $user->is_active
            ? 'Đã kích hoạt tài khoản.'
            : 'Đã vô hiệu hóa tài khoản.');
    }

    private function messages(): array
    {
        return [
            'full_name.required' => 'Vui lòng nhập họ tên.',
            'username.required'  => 'Vui lòng nhập tên đăng nhập.',
            'username.unique'    => 'Tên đăng nhập đã tồn tại.',
            'username.alpha_dash' => 'Tên đăng nhập chỉ gồm chữ, số, dấu gạch.',
            'email.required'     => 'Vui lòng nhập email.',
            'email.email'        => 'Email không hợp lệ.',
            'email.unique'       => 'Email đã được sử dụng.',
            'password.required'  => 'Vui lòng nhập mật khẩu.',
            'password.min'       => 'Mật khẩu tối thiểu 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'role.required'      => 'Vui lòng chọn vai trò.',
            'avatar.image'       => 'Avatar phải là file ảnh.',
            'avatar.max'         => 'Ảnh tối đa 2MB.',
        ];
    }
}
