<?php

namespace App\Livewire\Frontend\Components;

use Livewire\Component;

class Ads extends Component
{
    public $ad = null;

    public function mount()
    {
        $this->ad = '💥 Massive 55% Discount Just for You!';
    }
    public function render()
    {

        return view('livewire.frontend.components.ads');
    }
}
