<?php

namespace App\Livewire\Backend\Admin\Components\AdminManagement\Admin;

use App\DTOs\Admin\CreateAdminDTO;
use App\Enums\AdminStatus;
use App\Livewire\Forms\Backend\Admin\AdminManagement\AdminForm;
use App\Services\Admin\AdminService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    public AdminForm $form;

    protected AdminService $adminService;

    public function boot(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function mount(): void
    {
        $this->form->status = AdminStatus::ACTIVE->value;
    }

    public function render()
    {
        return view('livewire.backend.admin.components.admin-management.admin.create', [
            'statuses' => AdminStatus::options(),
        ]);
    }
    public function save()
    {
        $this->form->validate();
        try {
            $dto = CreateAdminDTO::fromArray([
                'name' => $this->form->name,
                'email' => $this->form->email,
                'password' => $this->form->password,
                'phone' => $this->form->phone,
                'address' => $this->form->address,
                'status' => $this->form->status,
                'avatar' => $this->form->avatar,
            ]);

            $admin = $this->adminService->createAdmin($dto);

            $this->dispatch('adminCreated');
           $this->success('Admin created successfully');
            // Redirect to user list
            return $this->redirect(route('admin.am.admin.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to create user: ' . $e->getMessage());
        }
    }

    public function cancel(): void
    {
        $this->redirect(route('admin.am.admin.index'), navigate: true);
    }
}
