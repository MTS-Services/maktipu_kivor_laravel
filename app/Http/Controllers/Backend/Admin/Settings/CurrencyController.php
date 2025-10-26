<?php

namespace App\Http\Controllers\Backend\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Currency;

class CurrencyController extends Controller
{
     protected $masterView = 'backend.admin.pages.settings.currency';

    public function index()
    {
        return view($this->masterView);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->masterView);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view($this->masterView, $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Currency::find($id);
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }

    public function view(string $id)
    {
        $data = Currency::find($id);
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }

    public function trash()
    {
        return view($this->masterView);
    }
}
