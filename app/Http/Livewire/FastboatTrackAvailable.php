<?php

namespace App\Http\Livewire;

use App\Models\FastboatTrack;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class FastboatTrackAvailable extends Component
{
    use WithPagination;

    protected $listeners = [
        'showAvailableRoute' => 'showAvailableRoute',
        'choosedDepartureFastboat' => 'choosedDepartureFastboat', 
    ];

    public $from;
    public $to;
    public $ways;
    public $date;
    public $rdate;
    public $passengers;

    protected $trackDepartures;
    protected $trackReturns;

    public $trackDepartureChoosed = null;
    public $trackReturnChoosed = null;

    public $show = false;

    public function mount() 
    {
        $this->fetch();
    }

    public function render()
    {
        return view('livewire.fastboat-track-available', [
            'trackDepartures' => $this->trackDepartures?->paginate(),
            'trackReturns' => $this->trackReturns?->paginate(20, '*', 'return_page'),
        ]);
    }

    public function toggle()
    {
        $this->show = !$this->show;
    }

    public function showAvailableRoute($data)
    {
        $this->from = $data['from'];
        $this->to = $data['to'];
        $this->ways = $data['ways'];
        $this->date = $data['date'];
        $this->rdate = $data['rdate'];
        $this->passengers = $data['passengers'];
        $this->fetch();
    }

    public function choosedDepartureFastboat(FastboatTrack $value)
    {
        dump($value);
        $this->trackDepartureChoosed = $value;
    }

    public function fetch()
    {
        if($this->from != '' && $this->to != '') {
            $this->show = true;
            $queryDeparture = FastboatTrack::with(['source', 'destination', 'group.fastboat'])
            ->whereHas('source', function($query) {
                $query->where('name', '=', $this->from);
            })
            ->whereHas('destination', function($query) {
                $query->where('name', '=', $this->to);
            });

            $rdate = Carbon::createFromFormat('Y-m-d', $this->date);
            if($rdate->isToday()) {
                $queryDeparture->whereTime('arrival_time', '>=',now());
            }

            $queryDeparture->withCount(['item_ordered' => function ($query) use($rdate) {
                return $query->whereDate('date', $rdate);
            }]);

            $this->trackDepartures = $queryDeparture;

            if($this->ways == 2) {
                $queryReturns = FastboatTrack::with(['source', 'destination'])
                ->whereHas('source', function($query) {
                    $query->where('name', '=', $this->to);
                })
                ->whereHas('destination', function($query) {
                    $query->where('name', '=', $this->from);
                });

                $rdate = Carbon::createFromFormat('Y-m-d', $this->rdate);
                if($rdate->isToday()) {
                    $queryReturns->whereTime('arrival_time', '>=',now());
                }

                $queryReturns->withCount(['item_ordered' => function ($query) use($rdate) {
                    return $query->whereDate('date', $rdate);
                }]);

                $this->trackReturns = $queryReturns;
            }
        }
    }
}
