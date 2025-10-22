<?php

namespace App\DTOs\Admin;

use App\Enums\AdminStatus;
use Illuminate\Http\UploadedFile;

class CreateAdminDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $phone = null,
        public readonly ?string $address = null,
        public readonly AdminStatus $status = AdminStatus::ACTIVE,
        public readonly ?UploadedFile $avatar = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            phone: $data['phone'] ?? null,
            address: $data['address'] ?? null,
            status: isset($data['status']) ? AdminStatus::from($data['status']) : AdminStatus::ACTIVE,
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
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => $this->status->value,
        ];
    }
}
