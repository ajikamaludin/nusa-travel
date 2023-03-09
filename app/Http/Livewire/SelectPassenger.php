<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectPassenger extends Component
{
    public $passengers;

    public function render()
    {
        return view('livewire.select-passenger');
    }

    public function updatedPassengers($value)
    {
        $this->emit('changePassengers', $value);
    }
}
