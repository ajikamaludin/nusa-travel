<?php

namespace App\Http\Livewire;

use Illuminate\Support\Carbon;
use Livewire\Component;

class SelectReturnDate extends Component
{
    protected $listeners = ['changeDate' => 'updateMinDate'];

    public $rdate;

    public $min;

    public function mount($date)
    {
        $this->min = $date;
    }

    public function render()
    {
        return view('livewire.select-return-date');
    }

    public function updatedRdate($value)
    {
        $this->emit('changeRdate', $value);
    }

    public function updateMinDate($value)
    {
        if ($value != '') {
            $date = Carbon::createFromFormat('Y-m-d', $value);
            if ($date->gte($this->rdate)) {
                $this->min = $date;
                $this->rdate = $date;
            }
        }
    }
}
