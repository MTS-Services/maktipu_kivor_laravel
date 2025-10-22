<?php

namespace App\Livewire\User;

use App\DTOs\User\CreateUserDTO;
use App\Enums\UserStatus;
use App\Livewire\User\Forms\UserForm;
use App\Services\User\UserService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('app')]
#[Title('Create User')]
class UserCreate extends Component
{
    use WithFileUploads, WithNotification;

    public UserForm $form;

    protected UserService $userService;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function mount(): void
    {
        $this->form->status = UserStatus::ACTIVE->value;
    }

    public function render()
    {
        return view('livewire.user.user-create', [
            'statuses' => UserStatus::options(),
        ]);
    }

    public function save()
    {
        $this->form->validate();

        try {
            $dto = CreateUserDTO::fromArray([
                'name' => $this->form->name,
                'email' => $this->form->email,
                'password' => $this->form->password,
                'phone' => $this->form->phone,
                'address' => $this->form->address,
                'status' => $this->form->status,
                'avatar' => $this->form->avatar,
            ]);

            $user = $this->userService->createUser($dto);

            $this->dispatch('userCreated');
            $this->success('User created successfully');

            // Redirect to user list
            return $this->redirect(route('users.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to create user: ' . $e->getMessage());
        }
    }

    public function cancel(): void
    {
        $this->redirect(route('users.index'), navigate: true);
    }
}
