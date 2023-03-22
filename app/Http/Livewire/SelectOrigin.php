<?php

namespace App\Http\Livewire;

use App\Models\FastboatPlace;
use Livewire\Component;

class SelectOrigin extends Component
{
    protected $listeners = ['changeDest' => 'updatePlaces'];

    public $dest;

    public $origin;

    public $places;

    public function mount()
    {
        $this->places = FastboatPlace::whereNull('data_source')->where('name', '!=', $this->dest)->orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.select-origin');
    }

    public function updatedOrigin($value)
    {
        $this->emit('changeOrigin', $value);
    }

    public function updatePlaces($origin)
    {
        $this->places = FastboatPlace::whereNull('data_source')->where('name', '!=', $origin)->orderBy('name', 'asc')->get();
    }
}
