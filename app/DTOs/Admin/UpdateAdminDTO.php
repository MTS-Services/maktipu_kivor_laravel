<?php

namespace App\DTOs\Admin;

use App\Enums\AdminStatus;
use Illuminate\Http\UploadedFile;

class UpdateAdminDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $password = null,
        public readonly ?string $phone = null,
        public readonly ?string $address = null,
        public readonly ?AdminStatus $status = null,
        public readonly ?UploadedFile $avatar = null,
        public readonly bool $removeAvatar = false,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: !empty($data['password']) ? $data['password'] : null,
            phone: $data['phone'] ?? null,
            address: $data['address'] ?? null,
            status: isset($data['status']) ? AdminStatus::from($data['status']) : null,
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
            'name' => $this->name,
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
        if ($this->status) {
            $data['status'] = $this->status->value;
        }

        return $data;
    }
}
