<?php

namespace App\Http\Livewire;

use App\Models\FastboatTrack;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class FastboatTrackAvailable extends Component
{
    use WithPagination, Actions;

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

    public function booted()
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
        $this->trackDepartureChoosed = null;
        $this->show = false;
    }

    public function showAvailableRoute($data)
    {
        if($data['from'] == null || $data['to'] == null) {
            $this->notification()->error(
                $title = 'Error !!!',
                $description = 'Origin and destination cant be empty'
            );
            return;
        }

        $this->from = $data['from'];
        $this->to = $data['to'];
        $this->ways = $data['ways'];
        $this->date = $data['date'];
        $this->rdate = $data['rdate'];
        $this->passengers = $data['passengers'];

        // $this->fetch();
    }

    public function choosedDepartureFastboat($value)
    {
        $track = session()->get('fastboat_cart_'.$value['type']);
        if ($value['type'] == 1) {
            $this->trackDepartureChoosed = FastboatTrack::find($track['track_id']);
            if ($this->ways == 1) {
                redirect()->route('customer.cart.fastboat');
            }

            return;
        }
        redirect()->route('customer.cart.fastboat');
    }

    public function changeDepartureFastboat()
    {
        $this->trackDepartureChoosed = null;

        session()->remove('carts');
        $this->emit('addCart');
    }

    public function fetch()
    {
        if ($this->from != null && $this->to != null) {
            $this->show = true;
            $queryDeparture = FastboatTrack::with(['source', 'destination', 'group.fastboat'])
            ->whereHas('source', function ($query) {
                $query->where('name', '=', $this->from);
            })
            ->whereHas('destination', function ($query) {
                $query->where('name', '=', $this->to);
            });

            $rdate = Carbon::createFromFormat('Y-m-d', $this->date);
            if ($rdate->isToday()) {
                $queryDeparture->whereTime('arrival_time', '>=', now());
            }

            $queryDeparture->withCount(['item_ordered' => function ($query) use ($rdate) {
                return $query->whereDate('date', $rdate);
            }]);

            $this->trackDepartures = $queryDeparture;

            if ($this->ways == 2) {
                $queryReturns = FastboatTrack::with(['source', 'destination'])
                ->whereHas('source', function ($query) {
                    $query->where('name', '=', $this->to);
                })
                ->whereHas('destination', function ($query) {
                    $query->where('name', '=', $this->from);
                });

                $rdate = Carbon::createFromFormat('Y-m-d', $this->rdate);
                if ($rdate->isToday()) {
                    $queryReturns->whereTime('arrival_time', '>=', now());
                }

                $queryReturns->withCount(['item_ordered' => function ($query) use ($rdate) {
                    return $query->whereDate('date', $rdate);
                }]);

                $this->trackReturns = $queryReturns;
            }
        }
    }
}
