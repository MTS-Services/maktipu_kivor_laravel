<?php

namespace App\DTOs\Language;

use App\Enums\LanguageDirections;
use App\Enums\LanguageStatus;

class UpdateLanguageDTO
{
    public function __construct(
        public readonly ?string $locale = null,
        public readonly ?string $name = null,
        public readonly ?string $native_name = null,
        public readonly ?LanguageStatus $status = null,
        public readonly ?bool $is_default = null,
        public readonly ?LanguageDirections $direction = null,
        public readonly ?string $flag_icon = null,
        public readonly ?string $country_code = null,
        public readonly ?int $updated_by = null
    ) {}

    /**
     * Create DTO instance from array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            locale: $data['locale'] ?? null,
            name: $data['name'] ?? null,
            native_name: $data['native_name'] ?? null,
            flag_icon: $data['flag_icon'] ?? null,
            status: isset($data['status']) ? LanguageStatus::from($data['status']) : null,
            direction: isset($data['direction']) ? LanguageDirections::from($data['direction']) : null,
            is_default: $data['is_default'] ?? null,
            country_code: $data['country_code'] ?? null,
            updated_by: $data['updated_by'] ?? null
        );
    }

    /**
     * Create DTO from request (Livewire validated data or FormRequest)
     */
    public static function fromRequest($request): self
    {
        return self::fromArray($request->validated());
    }

    /**
     * Convert DTO to array for model update
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->locale !== null) $data['locale'] = $this->locale;
        if ($this->name !== null) $data['name'] = $this->name;
        if ($this->native_name !== null) $data['native_name'] = $this->native_name;
        if ($this->flag_icon !== null) $data['flag_icon'] = $this->flag_icon;
        if ($this->status !== null) $data['status'] = $this->status->value;
        if ($this->direction !== null) $data['direction'] = $this->direction;
        if ($this->is_default !== null) $data['is_default'] = $this->is_default;
        if ($this->country_code !== null) $data['country_code'] = $this->country_code;
        if ($this->updated_by !== null) $data['updated_by'] = $this->updated_by;

        return $data;
    }
}
