<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FastboatCart extends Component
{
    public function render()
    {
        return view('livewire.fastboat-cart')
            ->layout('layouts.home');
    }
}
