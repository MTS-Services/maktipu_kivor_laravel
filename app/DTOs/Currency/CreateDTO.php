<?php

namespace App\DTOs\Currency;

use App\Enums\CurrencyStatus;
use App\Models\Currency;

class CreateDTO
{
    public function __construct(
        public readonly int $sort_order,
        public readonly string $code,
        public readonly string $symbol,
        public readonly string $name,
        public readonly float $exchange_rate, 
        public readonly int $decimal_places,
        public readonly CurrencyStatus $status = CurrencyStatus::ACTIVE,
        public readonly bool $is_default = false, 
    ) {}

    /**
     * Create DTO instance from array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            sort_order: $data['sort_order'] ?? 0,
            code: $data['code'],
            symbol: $data['symbol'],
            name: $data['name'],
            exchange_rate: $data['exchange_rate'],
            decimal_places: $data['decimal_places'],
            status: isset($data['status'])
                ? CurrencyStatus::from($data['status'])
                : CurrencyStatus::ACTIVE,
            is_default: $data['is_default'] ?? false,
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
            'sort_order' => $this->sort_order,
            'code' => $this->code,
            'symbol' => $this->symbol,
            'name' => $this->name,
            'exchange_rate' => $this->exchange_rate,
            'decimal_places' => $this->decimal_places,
            'status' => $this->status,
            'is_default' => $this->is_default,
            'created_by' => admin()->id
        ];
    }
}
