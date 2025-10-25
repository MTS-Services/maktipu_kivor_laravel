<?php

namespace App\DTOs\Language;

use App\Enums\LanguageDirections;
use App\Enums\LanguageStatus;
use App\Models\Language;
use Illuminate\Http\UploadedFile;

class CreateLanguageDTO
{
    public function __construct(
        public readonly string $locale,
        public readonly string $name,
        public readonly ?string $native_name = null,
        public readonly LanguageStatus $status = LanguageStatus::ACTIVE,
        public readonly bool $is_default = false,
        public readonly LanguageDirections $direction = LanguageDirections::LTR,
        public readonly ?string $flag_icon = null,
        public readonly ?string $country_code = null,
        public readonly ?int $created_by = null,
        
        
    ) {}

    /**
     * Create DTO instance from array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            locale: $data['locale'],
            name: $data['name'],
            native_name: $data['native_name'] ?? null,
            flag_icon: $data['flag_icon'] ?? null,
            status: isset($data['status'])
                ? LanguageStatus::from($data['status'])
                : LanguageStatus::ACTIVE,
            direction: isset($data['direction']) ? LanguageDirections::from($data['direction']) : LanguageDirections::LTR,
            is_default: $data['is_default'] ?? false,
            country_code: $data['country_code'] ?? null,
            created_by: $data['created_by'] ?? null

        );
    }

    /**
     * Create DTO from request (e.g., FormRequest or Livewire validated data)
     */
    public static function fromRequest($request): self
    {
        return self::fromArray($request->validated());
    }

    /**
     * Convert DTO to an array (for model creation)
     */
    public function toArray(): array
    {
        return [
            'locale' => $this->locale,
            'name' => $this->name,
            'native_name' => $this->native_name,
            'flag_icon' => $this->flag_icon,
            'status' => $this->status->value,
            'is_default' => $this->is_default,
            'direction' => $this->direction,
            'country_code' => $this->country_code,
            'created_by' => admin()->id
        ];
    }
}
