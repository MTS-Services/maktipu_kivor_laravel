<?php

namespace App\Livewire\Backend\Admin\Components\Language;

use App\Models\Language;
use Livewire\Component;

class View extends Component
{
     public Language $language;
    public function mount(Language $language): void
    {
        $this->language = $language;
    }
    public function render()
    {
        return view('livewire.backend.admin.components.language.view');
    }
}
