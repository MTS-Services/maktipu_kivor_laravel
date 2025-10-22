<?php

namespace App\DTOs\User;

use App\Enums\UserAccountStatus;
use Illuminate\Http\UploadedFile;

class UpdateUserDTO
{
    public function __construct(
        public readonly string $first_name,
        public readonly ?string $last_name = null,
        public readonly ?string $username = null,
        public readonly ?string $display_name = null,
        public readonly string $country_id,
        public readonly ?string $date_of_birth = null,
        public readonly string $email,
        public readonly ?string $password = null,
        public readonly ?string $phone = null,
        public readonly ?string $address = null,
        public readonly ?UserAccountStatus $account_status = null,
        public readonly ?UploadedFile $avatar = null,
        public readonly bool $removeAvatar = false,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            first_name: $data['first_name'],
            last_name: $data['last_name'] ?? null,
            username: $data['username'] ?? null,
            display_name: $data['display_name'] ?? null,
            country_id: $data['country_id'],
            date_of_birth: $data['date_of_birth'] ?? null,
            email: $data['email'],
            password: !empty($data['password']) ? $data['password'] : null,
            phone: $data['phone'] ?? null,
            address: $data['address'] ?? null,
            account_status: isset($data['account_status']) ? UserAccountStatus::from($data['account_status']) : null,
            avatar: $data['avatar'] ?? null,
            removeAvatar: $data['remove_avatar'] ?? false,
        );
    }

    public static function fromRequest($request): self
    {
        return self::fromArray($request->validated());
    }

    public function toArray(): array
    {
        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'display_name' => $this->display_name,
            'country_id' => $this->country_id,
            'date_of_birth' => $this->date_of_birth,
            'email' => $this->email,
        ];

        // Only include phone if not null
        if ($this->phone !== null) {
            $data['phone'] = $this->phone;
        }

        // Only include address if not null
        if ($this->address !== null) {
            $data['address'] = $this->address;
        }

        // Only include password if provided
        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        // Only include status if provided
        if ($this->account_status) {
            $data['account_status'] = $this->account_status->value;
        }

        return $data;
    }
}