<?php

namespace App\Http\Livewire;

use App\Models\FastboatPickup;
use Livewire\Component;

class SelectPickup extends Component
{
    public $origin;

    public $pickup;

    public $pickups;

    public function mount()
    {
        $this->pickups = FastboatPickup::whereHas(['source' => function ($query) {
            $query->where('name', $this->origin);
        }])
            ->orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.select-pickup');
    }

    public function updatingPickup($value)
    {
        $this->emit('selectPickup', ['pickup' => $value]);
    }
}
