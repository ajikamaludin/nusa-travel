<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FastboatTrackAvailable extends Component
{
    public $from;
    public $to;
    public $ways;
    public $date;
    public $rdate;

    public $trackDepartures;
    public $trackReturns;

    public $trackDepartureChoosed;
    public $trackReturnChoosed;

    public function mount() 
    {
        // 
    }

    public function render()
    {
        return view('livewire.fastboat-track-available');
    }
}
