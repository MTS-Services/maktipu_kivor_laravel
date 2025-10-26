<?php

namespace App\Livewire\Forms\Backend\Admin\Settings;

use App\Enums\CurrencyStatus;
use App\Models\Currency;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CurrencyForm extends Form
{
    
    public ?int $id = null;
    
    #[Validate('required|string|max:10')]
    public string $code = '';
    #[Validate('required|string|max:10')]
    public string $symbol = '';

    #[Validate('required|string|max:50')]
    public string $name = '';

    #[Validate('required')]
    public ?float $exchange_rate = null;

    #[Validate('required|integer')]
    public int $decimal_places = 2;

    #[Validate('required|string')]
    public ?string $status = CurrencyStatus::ACTIVE->value;

    #[Validate('nullable|boolean')]
    public int $is_default = 0;

    /**
     * Validation rules (handles create/update logic)
     */
    public function rules(): array
    {
        $codeRule = $this->isUpdating()
            ? 'required|string|max:10|unique:currencies,code,' . $this->id
            : 'required|string|max:10|unique:currencies,code';

        $nameRule = $this->isUpdating()
            ? 'required|string|max:50|unique:currencies,name,' . $this->id
            : 'required|string|max:50|unique:currencies,name';

        return [
            'code' => $codeRule,
            'symbol' => 'required|string|max:10',
            'name' => $nameRule,
            'exchange_rate' => 'required|double',
            'decimal_places' => 'required|integer',
            'status' => 'required|string|in:' . implode(',', array_column(CurrencyStatus::cases(), 'value')),
            'is_default' => 'nullable|boolean',
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'code.required' => 'The currency code is required .',
            'code.unique' => 'This currency code is already in use.',
            'symbol.required' => 'The currency symbol is required.',
            'name.required' => 'The currency name is required.',
            'name.unique' => 'This currency name is already in use.',
            'exchange_rate.required' => 'The exchange rate is required.',
            'decimal_places.required' => 'The decimal places is required.',
            'status.required' => 'Please select a status.',
            'is_default.required' => 'Please select a status.',

        ];
    }

    /**
     * Fill the form fields from a Language model
     */
    public function setData(Currency $currency): void
    {
        $this->id = $currency->id;
        $this->code = $currency->code;
        $this->symbol = $currency->symbol;
        $this->name = $currency->name;
        $this->exchange_rate = $currency->exchange_rate;
        $this->decimal_places = $currency->decimal_places;
        $this->status = $currency->status->value;
        $this->is_default = $currency->is_default ? 1 : 0;
    }

    /**
     * Reset form fields
     */
    public function reset(...$properties): void
    {
        $this->id = null;
        $this->code = '';
        $this->symbol = '';
        $this->name = '';
        $this->exchange_rate = '';
        $this->decimal_places = '';
        $this->status = '';
        $this->is_default = false;

        $this->resetValidation();
    }

    /**
     * Determine if the form is updating an existing record
     */
    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}