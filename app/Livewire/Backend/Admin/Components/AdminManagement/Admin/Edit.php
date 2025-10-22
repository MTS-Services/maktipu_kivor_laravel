<?php

namespace App\Livewire\Backend\Admin\Components\AdminManagement\Admin;

use App\DTOs\Admin\UpdateAdminDTO;
use App\Enums\AdminStatus;
use App\Livewire\Forms\Backend\Admin\AdminManagement\AdminForm;
use App\Models\Admin;
use App\Services\Admin\AdminService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, WithNotification;

    public AdminForm $form;
    public Admin $admin;
    public $existingAvatar;
    public $adminId;

    protected AdminService $adminService;


    public function boot(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function mount(Admin $admin): void
    {
        $this->admin = $admin;
        $this->adminId = $admin->id;
        $this->form->setAdmin($admin);
        $this->existingAvatar = $admin->avatar_url;

        Log::info('AdminEdit mounted', [
            'admin_id' => $admin->id,
            'form_data' => [
                'name' => $this->form->name,
                'email' => $this->form->email,
                'status' => $this->form->status,
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.backend.admin.components.admin-management.admin.edit', [
            'statuses' => AdminStatus::options(),
        ]);
    }

    public function save()
    {
        Log::info('Save method called', [
            'admin_id' => $this->adminId,
            'form_data' => [
                'name' => $this->form->name,
                'email' => $this->form->email,
                'password' => $this->form->password ? 'SET' : 'NOT SET',
                'phone' => $this->form->phone,
                'address' => $this->form->address,
                'status' => $this->form->status,
                'avatar' => $this->form->avatar ? 'FILE' : 'NULL',
                'remove_avatar' => $this->form->remove_avatar,
            ]
        ]);

        $this->form->validate();

        try {
            $dtoData = [
                'name' => $this->form->name,
                'email' => $this->form->email,
                'phone' => $this->form->phone,
                'address' => $this->form->address,
                'status' => $this->form->status,
                'remove_avatar' => $this->form->remove_avatar,
            ];

            // Only add password if it's provided
            if (!empty($this->form->password)) {
                $dtoData['password'] = $this->form->password;
            }

            // Only add avatar if it's uploaded
            if ($this->form->avatar) {
                $dtoData['avatar'] = $this->form->avatar;
            }

            Log::info('Creating DTO with data', ['dto_data' => $dtoData]);

            $dto = UpdateAdminDTO::fromArray($dtoData);

            Log::info('DTO created, calling service');

            $this->admin = $this->adminService->updateAdmin($this->adminId, $dto);

            Log::info('Admin updated successfully', ['admin_id' => $this->admin->id]);

            $this->existingAvatar = $this->admin->avatar_url;
            $this->form->avatar = null;
            $this->form->remove_avatar = false;
            $this->form->password = '';
            $this->form->password_confirmation = '';

            $this->dispatch('AdminUpdated');
            $this->success('Admin updated successfully');

            // Redirect to Admin list
            return $this->redirect(route('admin.am.admin.index'), navigate: true);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Failed to update Admin', [
                'admin_id' => $this->adminId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update Admin: ' . $e->getMessage());
        }
    }

    public function removeAvatar(): void
    {
        Log::info('removeAvatar called', ['admin_id' => $this->adminId]);
        $this->form->remove_avatar = true;
        $this->existingAvatar = null;
        $this->form->avatar = null;
    }

    public function cancel(): void
    {
        $this->redirect(route('admin.am.admin.index'), navigate: true);
    }
}
