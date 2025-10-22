<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Component;

class Header extends Component
{

    public string $pageSlug;

    public function mount($pageSlug = 'home')
    {
        $this->pageSlug = $pageSlug;
    }

    public function render()
    {
        return view('frontend.layouts.partials.header');
    }
}
