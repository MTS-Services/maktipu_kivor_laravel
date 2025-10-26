<?php

namespace App\Livewire\Backend\Admin\Components\Settings\Currency;

use App\DTOs\Currency\CreateDTO;
use App\Enums\CurrencyStatus;
use App\Livewire\Forms\Backend\Admin\Settings\CurrencyForm;
use App\Services\Admin\CurrencyService;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    public CurrencyForm $form;

    protected CurrencyService $currencyService;

    /**
     * Inject the CurrencyService via the boot method.
     */
    public function boot(CurrencyService $currencyService): void
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = CurrencyStatus::ACTIVE->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.components.settings.currency.create', [
            'statuses' => CurrencyStatus::options(),
        ]);
    }

    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {
        $this->form->validate();
        try {
            $dto = CreateDTO::fromArray([
                'code' => $this->form->code,
                'symbol' => $this->form->symbol,
                'name' => $this->form->name,
                'exchange_rate' => $this->form->exchange_rate,
                'decimal_places' => $this->form->decimal_places,
                'status' => $this->form->status,
                'is_default' => $this->form->is_default,
                'created_by' => admin()->id

            ]);

            $currency = $this->currencyService->createData($dto);

            $this->dispatch('currencyCreated');
            $this->success('Data created successfully.');

            return $this->redirect(route('admin.as.currency.index'), navigate: true);

        } catch (\Exception $e) {
            $this->error('Failed to create data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function cancel(): void
    {
        $this->redirect(route('admin.as.currency.index'), navigate: true);
    }
}
