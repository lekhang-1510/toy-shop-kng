<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function about()
    {
        return view('user.pages.about');
    }

    public function contact()
    {
        return view('user.pages.contact');
    }
}
