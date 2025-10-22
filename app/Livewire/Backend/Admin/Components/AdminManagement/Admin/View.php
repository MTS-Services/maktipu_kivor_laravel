<?php

namespace App\Livewire\Backend\Admin\Components\AdminManagement\Admin;

use App\Models\Admin;
use Livewire\Component;

class View extends Component
{

    public Admin $admin;
    public function mount(Admin $admin): void
    {
        $this->admin = $admin;
    }
    public function render()
    {
        return view('livewire.backend.admin.components.admin-management.admin.view');
    }
}
