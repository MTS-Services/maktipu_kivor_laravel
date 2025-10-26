<?php

namespace App\DTOs\Currency;

use App\Enums\CurrencyStatus;

class UpdateDTO
{
    public function __construct(
        public readonly ?int $sort_order = null,
        public readonly ?string $code = null,
        public readonly ?string $symbol = null,
        public readonly ?string $name = null,
        public readonly ?float $exchange_rate = null, 
        public readonly ?int $decimal_places = null,
        public readonly ?CurrencyStatus $status = null,
        public readonly ?bool $is_default = null, 
        public readonly ?int $updated_by = null,
    ) {}

    /**
     * Create DTO instance from array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            sort_order: $data['sort_order'] ?? null,
            code: $data['code'] ?? null,
            symbol: $data['symbol'] ?? null,
            name: $data['name'] ?? null,
            exchange_rate: $data['exchange_rate'] ?? null,
            decimal_places: $data['decimal_places'] ?? null,
            status: CurrencyStatus::from($data['status']) ?? null,
            is_default: $data['is_default'] ?? null,
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

        if ($this->sort_order !== null) $data['sort_order'] = $this->sort_order;
        if ($this->code !== null) $data['code'] = $this->code;
        if ($this->symbol !== null) $data['symbol'] = $this->symbol;
        if ($this->name !== null) $data['name'] = $this->name;
        if ($this->exchange_rate !== null) $data['exchange_rate'] = $this->exchange_rate;
        if ($this->decimal_places !== null) $data['decimal_places'] = $this->decimal_places;
        if ($this->status !== null) $data['status'] = $this->status;
        if ($this->is_default !== null) $data['is_default'] = $this->is_default;
        if ($this->updated_by !== null) $data['updated_by'] = $this->updated_by;
        return $data;
    }
}
