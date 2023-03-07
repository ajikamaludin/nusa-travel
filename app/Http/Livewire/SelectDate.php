<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectDate extends Component
{
    public $date;
    public $min;

    public function mount()
    {
        $this->min = now();
    }

    public function render()
    {
        return view('livewire.select-date');
    }
}
