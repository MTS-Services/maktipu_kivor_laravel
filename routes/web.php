<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Frontend\Pages\Home;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\User\UserCreate;
use App\Livewire\User\UserEdit;
use App\Livewire\User\UserList;

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    //     Route::redirect('settings', 'settings/profile');

    //     Route::get('settings/profile', Profile::class)->name('settings.profile');
    //     Route::get('settings/password', Password::class)->name('settings.password');
    //     Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', UserList::class)->name('index');
        Route::get('/create', UserCreate::class)->name('create');
        Route::get('/{user}/edit', UserEdit::class)->name('edit');
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/frontend.php';
require __DIR__ . '/fortify-admin.php';
