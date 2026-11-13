<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users'      => User::where('role', 'user')->count(),
            'categories' => Category::count(),
            'products'   => Product::count(),
            'low_stock'  => Product::where('stock', '<=', 10)->count(),
        ];

        $latestProducts = Product::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestProducts'));
    }
}
