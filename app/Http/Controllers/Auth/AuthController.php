<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ===== ĐĂNG KÝ =====
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:100|unique:users,username|alpha_dash',
            'email'     => 'required|email|max:255|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
        ], [
            'full_name.required'  => 'Vui lòng nhập họ tên.',
            'username.required'   => 'Vui lòng nhập tên đăng nhập.',
            'username.unique'     => 'Tên đăng nhập đã tồn tại.',
            'username.alpha_dash' => 'Tên đăng nhập chỉ gồm chữ, số, dấu gạch.',
            'email.required'      => 'Vui lòng nhập email.',
            'email.email'         => 'Email không hợp lệ.',
            'email.unique'        => 'Email đã được sử dụng.',
            'password.required'   => 'Vui lòng nhập mật khẩu.',
            'password.min'        => 'Mật khẩu tối thiểu 6 ký tự.',
            'password.confirmed'  => 'Mật khẩu xác nhận không khớp.',
        ]);

        // Role luôn là user, không cho đăng ký admin từ web
        $user = User::create([
            'full_name' => $data['full_name'],
            'username'  => $data['username'],
            'email'     => $data['email'],
            'password'  => $data['password'], // cast 'hashed' tự bcrypt
            'role'      => 'user',
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Đăng ký thành công!');
    }

    // ===== ĐĂNG NHẬP =====
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['username' => 'Tên đăng nhập hoặc mật khẩu không đúng.'])
                ->onlyInput('username');
        }

        // Kiểm tra tài khoản bị vô hiệu hóa
        if (!Auth::user()->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['username' => 'Tài khoản của bạn đã bị vô hiệu hóa.'])
                ->onlyInput('username');
        }

        $request->session()->regenerate();

        // Admin vào trang quản trị, user vào trang chủ
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    // ===== ĐĂNG XUẤT =====
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
