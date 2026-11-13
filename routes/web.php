<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\PageController as UserPageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use Illuminate\Support\Facades\Route;

// ===== TRANG CÔNG KHAI =====
Route::get('/', [UserHomeController::class, 'index'])->name('home');
Route::get('/products', [UserProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [UserProductController::class, 'show'])->name('products.show');
Route::get('/about', [UserPageController::class, 'about'])->name('about');
Route::get('/contact', [UserPageController::class, 'contact'])->name('contact');

// ===== KHÁCH (CHƯA ĐĂNG NHẬP) =====
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ===== USER ĐÃ ĐĂNG NHẬP =====
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [UserProfileController::class, 'editPassword'])->name('profile.password');
    Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// ===== ADMIN =====
Route::prefix('admin')->name('admin.')->middleware(['auth', 'active', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', AdminUserController::class)->except('show');
    Route::patch('users/{user}/toggle', [AdminUserController::class, 'toggle'])->name('users.toggle');

    Route::resource('categories', AdminCategoryController::class)->except('show');
    Route::get('products/export', [AdminProductController::class, 'export'])->name('products.export');
    Route::get('products/template', [AdminProductController::class, 'template'])->name('products.template');
    Route::post('products/import', [AdminProductController::class, 'import'])->name('products.import');
    Route::resource('products', AdminProductController::class)->except('show');
});


// 