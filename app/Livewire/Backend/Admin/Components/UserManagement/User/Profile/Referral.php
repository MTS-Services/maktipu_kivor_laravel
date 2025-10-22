<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User\Profile;

use App\Models\User;
use Livewire\Component;

class Referral extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user->load(['referral']);
    }
    public function render()
    {
        return view('livewire.backend.admin.components.user-management.user.profile.referral');
    }
}
