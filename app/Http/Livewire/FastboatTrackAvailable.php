<?php

namespace App\Http\Livewire;

use App\Models\FastboatTrack;
use Livewire\Component;
use Livewire\WithPagination;

class FastboatTrackAvailable extends Component
{
    use WithPagination;

    public $from;
    public $to;
    public $ways;
    public $date;
    public $rdate;
    public $passengers;

    public $trackDepartures;
    public $trackReturns;

    public $trackDepartureChoosed;
    public $trackReturnChoosed;

    public function mount() 
    {
        if($this->from != '' && $this->to != '') {
            $this->trackDepartures = FastboatTrack::with(['source', 'destination'])
                ->whereHas('source', function($query) {
                    $query->where('name', '=', $this->from);
                })
                ->whereHas('destination', function($query) {
                    $query->where('name', '=', $this->to);
                })->get();
        }
    }

    public function render()
    {
        return view('livewire.fastboat-track-available');
    }
}
