<?php

namespace App\Livewire\Backend\Admin\Components\UserManagement\User;

use App\Models\User;
use App\Models\Country;
use Livewire\Component;

use App\DTOs\User\UpdateUserDTO;
use App\Enums\UserAccountStatus;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithNotification;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Livewire\Forms\Backend\Admin\UserManagement\UserForm;

class Edit extends Component
{

    use WithFileUploads, WithNotification;


    public UserForm $form;
    public User $user;
    public $userId;
    public $existingAvatar;



    protected UserService $userService;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function mount(User $user): void
    {
        $this->user = $user;
        $this->userId = $user->id;
        $this->form->setUser($user);
        $this->existingAvatar = $user->avatar_url;
        // $this->form->date_of_birth->format('Y-m-d');


        Log::info('UserEdit mounted', [
            'user_id' => $user->id,
            'form_data' => [
                'first_name' => $this->form->first_name,
                'last_name' => $this->form->last_name,
                'username' => $this->form->username,
                'display_name' => $this->form->display_name,
                'date_of_birth' => $this->form->date_of_birth,
                'country_id' => $this->form->country_id,
                'email' => $this->form->email,
                'account_status' => $this->form->account_status,
            ]
        ]);
    }
    public function render()
    {
        return view('livewire.backend.admin.components.user-management.user.edit', [
            'statuses' => UserAccountStatus::options(),
            'countries' => Country::orderBy('name', 'asc')->get(),
        ]);
    }

    public function save()
    {
        Log::info('Save method called', [
            'user_id' => $this->userId,
            'form_data' => [
                'first_name' => $this->form->first_name,
                'last_name' => $this->form->last_name,
                'username' => $this->form->username,
                'display_name' => $this->form->display_name,
                'date_of_birth' => $this->form->date_of_birth,
                'country_id' => $this->form->country_id,
                'email' => $this->form->email,
                'password' => $this->form->password ? 'SET' : 'NOT SET',
                'phone' => $this->form->phone,
                'account_status' => $this->form->account_status,
                'avatar' => $this->form->avatar ? 'FILE' : 'NULL',
                'remove_avatar' => $this->form->remove_avatar,
            ]
        ]);

        $this->form->validate();

        try {
            $dtoData = [
                'first_name' => $this->form->first_name,
                'last_name' => $this->form->last_name,
                'username' => $this->form->username,
                'display_name' => $this->form->display_name,
                'date_of_birth' => $this->form->date_of_birth,
                'country_id' => $this->form->country_id,
                'email' => $this->form->email,
                'phone' => $this->form->phone,
                'account_status' => $this->form->account_status,
                'remove_avatar' => $this->form->remove_avatar,
            ];
            // Only add password if it's provided
            if (!empty($this->form->password)) {
                $dtoData['password'] = $this->form->password;
            };


            // Only add avatar if it's provided
            if ($this->form->avatar) {
                $dtoData['avatar'] = $this->form->avatar;
            }


            $dto = UpdateUserDTO::fromArray($dtoData);

            $this->user = $this->userService->updateUser($this->userId, $dto);

            // $this->existingAvatar = $this->admin->avatar_url;
            $this->form->avatar = null;
            $this->form->remove_avatar = false;
            $this->form->password = '';
            $this->form->password_confirmation = '';

            $this->dispatch('UserUpdated');
            $this->success('User updated successfully');
            return redirect()->route('admin.um.user.index');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Failed to update User', [
                'user_id' => $this->userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update User: ' . $e->getMessage());
            //  session()->flash('error', 'Failed to update User: ' . $e->getMessage());
        }
    }
    public function removeAvatar(): void
    {
        Log::info('removeAvatar called', ['user_id' => $this->userId]);
        $this->form->remove_avatar = true;
        $this->existingAvatar = null;
        $this->form->avatar = null;
    }

    public function cancel(): void
    {
        $this->redirect(route('admin.um.user.index'), navigate: true);
    }
}
