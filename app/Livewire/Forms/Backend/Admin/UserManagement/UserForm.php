<?php

namespace App\Livewire\Forms\Backend\Admin\UserManagement;

use Livewire\Form;
use App\Enums\UserStatus;
use App\Enums\UserAccountStatus;
use Livewire\Attributes\Validate;

class UserForm extends Form
{
    #[Validate('required|string|max:255')]
    public $first_name = '';

    #[Validate('nullable|string|max:255')]
    public $last_name = '';

    #[Validate('nullable|string|max:255|regex:/^[A-Za-z0-9_\-\$]+$/')]
    public $username = '';

    #[Validate('nullable|date')]
    public $date_of_birth = '';

    #[Validate('required|exists:countries,id')]
    public $country_id = '';

     #[Validate('required|string|max:255')]
    public $language = '';

    #[Validate('nullable|string|max:255')]
    public $display_name = '';

    #[Validate('required|email|max:255')]
    public $email = '';

    #[Validate('nullable|string|min:8')]
    public $password = '';

    #[Validate('nullable|string|min:8|same:password')]
    public $password_confirmation = '';

    #[Validate('nullable|string|max:20')]
    public $phone = '';

    #[Validate('required|string')]
    public $account_status = '';

    #[Validate('nullable|image|max:2048')]
    public $avatar;

    public $remove_avatar = false;

    public function rules(): array
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255|regex:/^[A-Za-z0-9_\-\$]+$/',
            'display_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'country_id' => 'required|exists:countries,id',
            'language' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => $this->isUpdating() ? 'nullable|string|min:8' : 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'account_status' => 'required|string|in:' . implode(',', array_column(UserAccountStatus::cases(), 'value')),
            'avatar' => 'nullable|image|max:2048',
        ];

        return $rules;
    }

    public function setUser($user): void
    {
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->username = $user->username;
        $this->display_name = $user->display_name;
        $this->country_id = $user->country_id;
        $this->date_of_birth = $user->date_of_birth;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->account_status = $user->account_status->value;
    }

    public function reset(...$properties): void
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->username = '';
        $this->display_name = '';
        $this->country_id = '';
        $this->date_of_birth = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->phone = '';
        $this->account_status = UserAccountStatus::ACTIVE->value;
        $this->avatar = null;
        $this->remove_avatar = false;

        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->email);
    }
}
