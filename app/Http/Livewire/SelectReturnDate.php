<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectReturnDate extends Component
{
    public $rdate;
    public $min;

    public function mount()
    {
        $this->min = now();
    }

    public function render()
    {
        return view('livewire.select-return-date');
    }
}
