<?php

namespace App\Http\Livewire;

use App\Models\FastboatDropoff;
use Livewire\Component;

class SelectDropoff extends Component
{
    public $dropoff;

    public $dropoffs;

    public function mount()
    {
        $this->dropoffs = FastboatDropoff::orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.select-dropoff');
    }

    public function updatingDropoff($value)
    {
        $this->emit('selectDropoff', ['dropoff' => $value]);
    }
}
