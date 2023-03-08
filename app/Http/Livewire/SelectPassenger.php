<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectPassenger extends Component
{
    public $passengers;
    public $count = [1,2,3,4];

    public function render()
    {
        return view('livewire.select-passenger');
    }

    public function updatedPassangers($value)
    {
        $this->emit('changePassengers', $value);
    }
}
