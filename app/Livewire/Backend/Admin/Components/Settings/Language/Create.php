<?php

namespace App\Livewire\Backend\Admin\Components\Settings\Language;

use App\DTOs\Language\CreateLanguageDTO;
use App\Enums\LanguageDirections;
use App\Enums\LanguageStatus;
use App\Livewire\Forms\Backend\Admin\Settings\LanguageForm;
use App\Services\Admin\LanguageService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    public LanguageForm $form;

    protected LanguageService $languageService;

    /**
     * Inject the LanguageService via the boot method.
     */
    public function boot(LanguageService $languageService): void
    {
        $this->languageService = $languageService;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = LanguageStatus::ACTIVE->value;
        $this->form->direction = LanguageDirections::LTR->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.components.settings.language.create', [
            'statuses' => LanguageStatus::options(),
            'directions' => LanguageDirections::options(),
        ]);
    }

    /**
     * Handle form submission to create a new language.
     */
    public function save()
    {
        $this->form->validate();
        $flagIcon = null;
            if (!empty($this->form->country_code)) {
                $flagIcon = 'https://flagcdn.com/' . strtolower($this->form->country_code) . '.svg';
            }

        try {
            $dto = CreateLanguageDTO::fromArray([
                'locale' => $this->form->locale,
                'name' => $this->form->name,
                'country_code'=> $this->form->country_code,
                'native_name' => $this->form->native_name,
                'flag_icon' => $flagIcon,
                'status' => $this->form->status,
                'is_default' => $this->form->is_default,
                'direction' => $this->form->direction,
                'created_by' => admin()->id

            ]);

            $language = $this->languageService->createLanguage($dto);

            $this->dispatch('languageCreated');
            $this->success('Language created successfully.');

            return $this->redirect(route('admin.as.language.index'), navigate: true);

        } catch (\Exception $e) {
            $this->error('Failed to create language: ' . $e->getMessage());
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function cancel(): void
    {
        $this->redirect(route('admin.as.language.index'), navigate: true);
    }
}
