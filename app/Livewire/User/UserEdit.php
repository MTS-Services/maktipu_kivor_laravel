<?php

namespace App\Livewire\User;

use App\DTOs\User\UpdateUserDTO;
use App\Enums\UserStatus;
use App\Livewire\User\Forms\UserForm;
use App\Models\User;
use App\Services\User\UserService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Log;

#[Layout('app')]
#[Title('Edit User')]
class UserEdit extends Component
{
    use WithFileUploads, WithNotification;

    public UserForm $form;
    public User $user;
    public $existingAvatar;
    public $userId;

    protected UserService $userService;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }
   
    public function mount(User $user): void
    {
        $this->user = $user;
        dd($this->user);
        $this->userId = $user->id;
        $this->form->setUser($user);
        $this->existingAvatar = $user->avatar_url;
        
        Log::info('UserEdit mounted', [
            'user_id' => $user->id,
            'form_data' => [
                'name' => $this->form->name,
                'email' => $this->form->email,
                'status' => $this->form->status,
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.user.user-edit', [
            'statuses' => UserStatus::options(),
        ]);
    }

    public function save()
    {
        Log::info('Save method called', [
            'user_id' => $this->userId,
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

            $dto = UpdateUserDTO::fromArray($dtoData);

            Log::info('DTO created, calling service');

            $this->user = $this->userService->updateUser($this->userId, $dto);
            
            Log::info('User updated successfully', ['user_id' => $this->user->id]);

            $this->existingAvatar = $this->user->avatar_url;
            $this->form->avatar = null;
            $this->form->remove_avatar = false;
            $this->form->password = '';
            $this->form->password_confirmation = '';

            $this->dispatch('userUpdated');
            $this->success('User updated successfully');

            // Redirect to user list
            return $this->redirect(route('users.index'), navigate: true);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Failed to update user', [
                'user_id' => $this->userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update user: ' . $e->getMessage());
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
        $this->redirect(route('users.index'), navigate: true);
    }
}