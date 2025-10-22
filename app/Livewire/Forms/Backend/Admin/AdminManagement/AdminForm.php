<?php

namespace App\Livewire\Forms\Backend\Admin\AdminManagement;

use App\Enums\AdminStatus;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AdminForm extends Form
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
            'status' => 'required|string|in:' . implode(',', array_column(AdminStatus::cases(), 'value')),
            'avatar' => 'nullable|image|max:2048',
        ];

        return $rules;
    }

    public function setAdmin($admin): void
    {
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->phone = $admin->phone;
        $this->address = $admin->address;
        $this->status = $admin->status->value;
    }

    public function reset(...$properties): void
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->phone = '';
        $this->address = '';
        $this->status = AdminStatus::ACTIVE->value;
        $this->avatar = null;
        $this->remove_avatar = false;

        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->email);
    }
}
