<?php

namespace App\Http\Livewire;

use App\Models\FastboatPlace;
use Livewire\Component;

class SelectDestination extends Component
{
    protected $listeners = ['changeOrigin' => 'updatePlaces'];

    public $origin;

    public $dest;

    public $places;

    public function mount()
    {
        $this->places = FastboatPlace::where('name', '!=', $this->origin)->orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.select-destination');
    }

    public function updatedDest($value)
    {
        $this->emit('changeDest', $value);
    }

    public function updatePlaces($origin)
    {
        $this->places = FastboatPlace::where('name', '!=', $origin)->orderBy('name', 'asc')->get();
    }
}
