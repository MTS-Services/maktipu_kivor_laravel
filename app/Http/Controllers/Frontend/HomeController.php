<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $masterView = 'frontend.pages.home';

    public function index()
    {
        return view($this->masterView);
    }
}
