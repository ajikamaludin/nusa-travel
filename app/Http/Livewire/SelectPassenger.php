<?php

namespace App\Http\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;

class SelectPassenger extends Component
{
    use Actions;

    public $passengers;

    public $infants;

    public function render()
    {
        return view('livewire.select-passenger');
    }

    public function updatedPassengers($value)
    {
        $this->emit('changePassengers', $value);
    }

    public function updatedInfants($value)
    {
        if ($this->passengers < $value) {
            $this->dialog()->error(
                $title = 'Warning !!!',
                $description = 'Infant cant more than persons'
            );

            $this->infants = $this->passengers;

            return;
        }
        $this->emit('changeInfants', $value);
    }
}
