<?php

namespace App\Http\Controllers\Backend\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $masterView = 'backend.admin.pages.user-management.user.user';

    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view($this->masterView);
    }
    public function create()
    {
        return view($this->masterView);
    }
    public function view(string $id)
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function edit(string $id)
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function trash()
    {
        return view($this->masterView);
    }
    public function profileInfo($id)
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function shopInfo($id)
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function kycInfo($id)
    {
        
        $user = $this->userService->getUserById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function statistic($id)
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function referral($id)
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
}
