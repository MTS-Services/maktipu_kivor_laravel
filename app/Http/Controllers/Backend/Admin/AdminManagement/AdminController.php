<?php

namespace App\Http\Controllers\Backend\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{


    protected $masterView = 'backend.admin.pages.admin-management.admin.admin';

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            abort(404);
        }
        return view($this->masterView, [
            'admin' => $admin
        ]);
    }

    public function view(string $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            abort(404);
        }
        return view($this->masterView, [
            'admin' => $admin
        ]);
    }

    public function trash()
    {
        return view($this->masterView);
    }
}
