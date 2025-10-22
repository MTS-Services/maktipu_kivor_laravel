<?php

use App\Livewire\Backend\User\Components\Profile;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'userVerify'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.user.pages.dashboard');
    })->name('dashboard');
    Route::get('/profile', function () {
        return view('backend.user.pages.profile');
    })->name('profile');
});
