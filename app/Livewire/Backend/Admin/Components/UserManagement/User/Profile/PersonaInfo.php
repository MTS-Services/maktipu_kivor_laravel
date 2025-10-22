<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User\Profile;

use App\Models\User;
use Livewire\Component;
use App\Services\User\UserService;

class PersonaInfo extends Component
{
    public User $user;

    // protected UserService $userService;

    // public function boot(UserService $userService)
    // {
    //     $this->userService = $userService;
    // }

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.backend.admin.components.user-management.user.profile.persona-info');
    }
}
