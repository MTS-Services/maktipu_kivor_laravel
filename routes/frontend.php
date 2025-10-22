<?php

use App\Livewire\Frontend\Buttons;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.pages.home');
})->name('home');
