<?php

namespace App\Livewire\User\Forms;

use App\Enums\UserStatus;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|email|max:255')]
    public $email = '';

    #[Validate('nullable|string|min:8')]
    public $password = '';

    #[Validate('nullable|string|min:8|same:password')]
    public $password_confirmation = '';

    #[Validate('nullable|string|max:20')]
    public $phone = '';

    #[Validate('nullable|string')]
    public $address = '';

    #[Validate('required|string')]
    public $status = '';

    #[Validate('nullable|image|max:2048')]
    public $avatar;

    public $remove_avatar = false;

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => $this->isUpdating() ? 'nullable|string|min:8' : 'required|string|min:8',
            'password_confirmation' => 'nullable|string|min:8|same:password',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|string|in:' . implode(',', array_column(UserStatus::cases(), 'value')),
            'avatar' => 'nullable|image|max:2048',
        ];

        return $rules;
    }

    public function setUser($user): void
    {
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->status = $user->status->value;
    }

    public function reset(...$properties): void
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->phone = '';
        $this->address = '';
        $this->status = UserStatus::ACTIVE->value;
        $this->avatar = null;
        $this->remove_avatar = false;
        
        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->email);
    }
}