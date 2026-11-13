<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $latestProducts = Product::with('category')->latest()->take(8)->get();

        return view('user.home', compact('categories', 'latestProducts'));
    }
}
