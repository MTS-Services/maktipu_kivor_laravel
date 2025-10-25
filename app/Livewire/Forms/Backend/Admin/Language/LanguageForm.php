<?php

namespace App\Livewire\Forms\Backend\Admin\Language;

use App\Enums\LanguageDirections;
use App\Enums\LanguageStatus;
use App\Models\Language;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LanguageForm extends Form
{
    #[Validate('required|string|max:10|unique:languages,locale')]
    public string $locale = '';
    #[Validate('required|string|max:10|unique:languages,country_code')]
    public string $country_code = '';

    #[Validate('required|string|max:50|unique:languages,name')]
    public string $name = '';

    #[Validate('nullable|string|max:255')]
    public string $native_name = '';

    #[Validate('nullable|string|max:255')]
    public string $flag_icon = '';

    #[Validate('required|string')]
    public string $status = '';

    #[Validate('boolean')]
    public bool $is_default = false;

     #[Validate('required|string')]
    public string $direction = '';

    /**
     * Validation rules (handles create/update logic)
     */
    public function rules(): array
    {
        $localeRule = $this->isUpdating()
            ? 'required|string|max:10|unique:languages,locale,' . $this->locale . ',locale'
            : 'required|string|max:10|unique:languages,locale';

        $nameRule = $this->isUpdating()
            ? 'required|string|max:50|unique:languages,name,' . $this->name . ',name'
            : 'required|string|max:50|unique:languages,name';
        $countryCodeRule = $this->isUpdating()
            ? 'required|string|max:50|unique:languages,country_code,' . $this->country_code . ',country_code'
            : 'required|string|max:50|unique:languages,country_code';

        return [
            'locale' => $localeRule,
            'name' => $nameRule,
            'country_code' => $countryCodeRule,
            'native_name' => 'nullable|string|max:255',
            'flag_icon' => 'nullable|string|max:255',
            'status' => 'required|string|in:' . implode(',', array_column(LanguageStatus::cases(), 'value')),
            'is_default' => 'boolean',
            'direction' => 'required|string|in:' . implode(',', array_column(LanguageDirections::cases(), 'value')),
        ];
    }

    /**
     * Fill the form fields from a Language model
     */
    public function setLanguage($language): void
    {
        $this->locale = $language->locale;
        $this->name = $language->name;
        $this->native_name = $language->native_name;
        $this->flag_icon = $language->flag_icon;
        $this->status = $language->status;
        $this->direction = $language->direction;
        $this->is_default = $language->is_default;
    }

    /**
     * Reset form fields
     */
    public function reset(...$properties): void
    {
        $this->locale = '';
        $this->name = '';
        $this->native_name = '';
        $this->flag_icon = '';
        $this->status = LanguageStatus::ACTIVE->value;
        $this->is_default = false;
        $this->direction = 'ltr';

        $this->resetValidation();
    }

    /**
     * Determine if the form is updating an existing record
     */
    protected function isUpdating(): bool
    {
        return !empty($this->locale);
    }
}
