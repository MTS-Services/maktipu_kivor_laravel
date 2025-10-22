<?php

namespace App\DTOs\User;

use App\Enums\UserAccountStatus;
use Illuminate\Http\UploadedFile;

class CreateUserDTO
{
    public function __construct(
        public readonly string $first_name,
        public readonly ?string $last_name = null,
        public readonly ?string $username = null,
        public readonly ?string $display_name = null,
        public readonly string $country_id,
        public readonly string $language,
        public readonly ?string $date_of_birth = null,
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $phone = null,
        public readonly UserAccountStatus $account_status = UserAccountStatus::ACTIVE,
        public readonly ?UploadedFile $avatar = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            first_name: $data['first_name'],
            last_name: $data['last_name'] ?? null,
            username: $data['username'] ?? null,
            display_name: $data['display_name'] ?? null,
            country_id: $data['country_id'],
            language: $data['language'],
            date_of_birth: $data['date_of_birth'] ?? null,
            email: $data['email'],
            password: $data['password'],
            phone: $data['phone'] ?? null,
            account_status: isset($data['account_status']) ? UserAccountStatus::from($data['account_status']) : UserAccountStatus::ACTIVE,
            avatar: $data['avatar'] ?? null,
        );
    }

    public static function fromRequest($request): self
    {
        return self::fromArray($request->validated());
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'display_name' => $this->display_name,
            'country_id' => $this->country_id,
            'date_of_birth' => $this->date_of_birth,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'phone' => $this->phone,
            'account_status' => $this->account_status->value,
        ];
    }
}