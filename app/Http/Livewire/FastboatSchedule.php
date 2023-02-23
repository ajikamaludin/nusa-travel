<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FastboatSchedule extends Component
{
    public $date;
    public $return_date;
    public $ways = 1;
    public $from;
    public $to;

    public function mount()
    {
        // 
    }

    public function render()
    {
        return view('livewire.fastboat-schedule');
    }
}
