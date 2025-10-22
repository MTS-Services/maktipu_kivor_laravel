<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User\Profile;

use App\Models\User;
use App\Services\User\UserService;
use Livewire\Component;

class ShopInfo extends Component
{
    public User $user;

    protected UserService $userService;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function mount(User $user)
    {
        $this->user = $user->load(['seller']);
    }
    public function render()
    {
        return view('livewire.backend.admin.components.user-management.user.profile.shop-info');
    }
}
