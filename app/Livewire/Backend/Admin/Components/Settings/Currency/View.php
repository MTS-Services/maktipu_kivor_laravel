<?php

namespace App\Livewire\Backend\Admin\Components\Settings\Currency;

use App\Models\Currency;
use Livewire\Component;

class View extends Component
{
    public Currency $data;
    public function mount(Currency $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.components.settings.currency.view');
    }
}
