<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Backend\Admin\Components\Dashboard;
use App\Livewire\Backend\Admin\Components\UserManagement\AllUser;
use App\Http\Controllers\Backend\Admin\UserManagement\UserController;
use App\Http\Controllers\Backend\Admin\AdminManagement\AdminController;
use App\Http\Controllers\Backend\Admin\Settings\CurrencyController;
use App\Http\Controllers\Backend\Admin\Settings\LanguageController;
use App\Models\Language;

Route::middleware(['auth:admin', 'admin', 'adminVerify'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.admin.pages.dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'admin-management', 'as' => 'am.'], function () {
        Route::controller(AdminController::class)->name('admin.')->prefix('admin')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });
    });

    Route::group(['prefix' => 'application-settings', 'as' => 'as.'], function () {
        Route::controller(LanguageController::class)->name('language.')->prefix('language')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });

        Route::controller(CurrencyController::class)->name('currency.')->prefix('currency')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });
    });

    Route::group(['prefix' => 'user-management', 'as' => 'um.'], function () {
        Route::controller(UserController::class)->name('user.')->prefix('user')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/trash', 'trash')->name('trash');
        });
    });
});
