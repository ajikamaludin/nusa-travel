<?php

namespace App\Http\Livewire;

use App\Models\FastboatTrack;
use App\Services\EkajayaService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public $infants;

    protected $trackDepartures;

    protected $trackReturns;

    public $trackDepartureChoosed = null;

    public $trackReturnChoosed = null;

    public $show = false;

    public function mount()
    {
        $this->fetch();
    }

    public function booted()
    {
        $this->fetch();
    }

    public function render()
    {
        return view('livewire.fastboat-track-available', [
            'passengers' => $this->passengers,
            'date' => $this->date,
            'rdate' => $this->rdate,
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
            $this->dialog()->error(
                $title = 'Warning !!!',
                $description = 'Please choose Origin and Destination'
            );

            return;
        }

        $this->from = $data['from'];
        $this->to = $data['to'];
        $this->ways = $data['ways'];
        $this->date = $data['date'];
        $this->rdate = $data['rdate'];
        $this->passengers = $data['passengers'];
        $this->infants = $data['infants'];

        $this->fetch();
    }

    public function choosedDepartureFastboat($value)
    {
        session()->forget(['persons', 'contact', 'dropoff']);

        if ($value['type'] == 1) {
            $this->trackDepartureChoosed = FastboatTrack::find($value['track_id']);
            if ($this->ways == 1) {
                // remove return order if any return ordered before
                $carts = collect(session('carts'))->filter(function ($cart) {
                    if ($cart['fastboat_cart'] == 1) {
                        return $cart;
                    }
                })->toArray();

                session(['carts' => $carts]);

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
            // TODO: call ekajaya service api
            EkajayaService::search($this->from, $this->to, $this->date, $this->ways);

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
            if (Auth::guard('customer')->check()) {
                if (auth('customer')->user()->is_agent == 1) {
                    $customerId = auth('customer')->user()->id;

                    $queryDeparture->leftJoin('fastboat_track_agents',function($join) use ($customerId){
                        $join->on('fastboat_track_id','=','fastboat_tracks.id');
                        $join->where('fastboat_track_agents.customer_id','=', $customerId);
                    })

                    ->select('fastboat_tracks.id as id', 'fastboat_tracks.fastboat_track_group_id', 'fastboat_source_id', 'fastboat_destination_id', 'arrival_time', 'departure_time', DB::raw('COALESCE (fastboat_track_agents.price,fastboat_tracks.price) as price'), 'is_publish', 'fastboat_tracks.created_at', 'fastboat_tracks.updated_at', 'fastboat_tracks.created_by');
                }
            }

            $this->trackDepartures = $queryDeparture->where('is_publish', 1);

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

                $this->trackReturns = $queryReturns->where('is_publish', 1);
            }
        }
    }
}
