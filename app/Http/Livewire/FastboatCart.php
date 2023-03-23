<?php

namespace App\Http\Livewire;

use App\Mail\OrderPayment;
use App\Models\CarRental;
use App\Models\Customer;
use App\Models\FastboatDropoff;
use App\Models\FastboatPickup;
use App\Models\FastboatTrack;
use App\Models\FreeTicketPromo;
use App\Models\Order;
use App\Models\Promo;
use App\Services\AsyncService;
use App\Services\EkajayaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Nette\Utils\DateTime;

class FastboatCart extends Component
{
    public $show = true;

    public $carts = [];

    public $contact = [];

    public $persons = [];

    public $showContact = false;

    public $dropoffs = [];

    public $dropoff;

    public $pickups = [];

    public $pickup;

    public $pickupSelected = null;

    public $validContact = false;

    public $isAllValid = false;

    public $view = 1;

    public $total = 0;

    public $total_payed = 0;

    public $promos = [];

    public $discount = 0;

    public $infants = 0;

    public function mount()
    {
        $this->contact = session()->get('contact', []);
        if ($this->contact != []) {
            $this->validContact = true;
        }
        $this->persons = session()->get('persons', []);
        $this->isAllValid = $this->checkAllValid();

        $this->infants = session()->get('infants', 0);

        $this->pickupSelected = session()->get('pickup', null);
        $this->pickup = $this->pickupSelected['name'] ?? null;
        // $this->dropoff = session()->get('dropoff');
        // $this->dropoffs = FastboatDropoff::orderBy('name', 'asc')->get();
    }

    public function booted()
    {
        $carts = session()->get('carts') ?? [];
        $carts = collect($carts)->filter(function ($cart) {
            if (array_key_exists('fastboat_cart', $cart)) {
                return $cart;
            }
        });

        $tracks = FastboatTrack::with(['destination', 'source', 'group.fastboat'])
            ->whereIn('id', $carts->keys())->get();

        $this->carts = $carts->map(function ($cart, $key) use ($tracks) {
            $cart['track'] = $tracks->where('id', $key)->first();

            if (! property_exists($this, 'showPerson_1')) {
                foreach (range(1, $cart['qty'] + $this->infants) as $i => $q) {
                    $this->{"showPerson_$i"} = false;
                }
            }

            return $cart;
        });

        if (count($this->carts) > 0 && count($this->persons) == 0) {
            $qty = collect($this->carts)->value('qty');
            foreach (range(0, $qty - 1) as $key => $i) {
                $this->persons[$i] = [
                    'key' => $key + 1,
                    'type' => '0',
                ];
            }

            if ($this->infants != 0) {
                foreach(range($i + 1, $i + $this->infants) as $key => $j) {
                    $this->persons[$j] = [
                        'key' => $key + 1,
                        'type' => '1',
                    ];
                }
            }
        }

        $origin = $this->carts->first()['track']->source->id;
        $this->pickups = FastboatPickup::with(['car'])->whereHas('source', function ($query) use ($origin) {
            $query->where('id', '=', $origin);
        })
        ->orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.fastboat-cart');
    }

    public function toggle()
    {
        $this->show = ! $this->show;
    }

    public function saveContact()
    {
        $this->resetValidation();
        $validate = Validator::make($this->contact, [
            'name' => 'required|string|max:255|min:3',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20',
            'nation' => 'required|string',
            'national_id' => 'required|numeric',
            'email' => 'required|email',
        ]);

        if ($validate->fails()) {
            foreach ($validate->messages()->toArray() as $name => $err) {
                $this->addError($name, $err);
            }

            return;
        }

        $this->showContact = false;
        $this->validContact = true;
        $this->isAllValid = $this->checkAllValid();
    }

    public function addContactToPerson()
    {
        $this->persons[0] = array_merge(
            $this->persons[0],
            $this->contact
        );

        $this->isAllValid = $this->checkAllValid();
    }

    public function saveTraveler($i)
    {
        $this->resetValidation();
        $validate = Validator::make($this->persons[$i] ?? [], [
            'name' => 'required|string|max:255|min:3',
            'nation' => 'required|string',
            'national_id' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            foreach ($validate->messages()->toArray() as $name => $err) {
                $this->addError($name, $err);
            }

            return;
        }

        $this->{"showPerson_$i"} = false;
        $this->isAllValid = $this->checkAllValid();
    }

    public function checkAllValid()
    {
        return $this->validContact && ! in_array([], $this->persons);
    }

    public function continue()
    {
        session([
            'persons' => $this->persons,
            'contact' => $this->contact,
            'pickup' => $this->pickupSelected,
            // 'dropoff' => $this->dropoff,
        ]);

        $this->applyPromos();
        $this->view = 2;
    }

    public function back()
    {
        $this->discount = 0;
        $this->promos = [];
        $this->total = 0;
        $this->total_payed = 0;
        $this->view = 1;
    }

    public function payment()
    {
        DB::beginTransaction();
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
        } else {
            $customer = Customer::hardSearch(
                $this->contact['phone'],
                $this->contact['national_id'],
                $this->contact['email'],
                [
                    'name' => $this->contact['name'],
                    'nation' => $this->contact['nation'],
                ]
            );
        }

        $pickup = $this->pickupSelected;

        // create order
        $order = Order::create([
            'order_code' => Order::generateCode(),
            'customer_id' => $customer->id,
            'total_amount' => $this->total_payed,
            'total_discount' => $this->discount,
            'order_type' => Order::TYPE_ORDER,
            'date' => now(),
            'pickup' => $pickup['name'] ?? null,
        ]);

        // $dropoff = FastboatDropoff::where('name', $this->dropoff)->first();

        // insert items -> insert passengers
        foreach ($this->carts as $trackId => $cart) {
            $item = $order->items()->create([
                'entity_order' => $cart['type'],
                'entity_id' => $trackId,
                'description' => $cart['track']->source->name.' - '.$cart['track']->destination->name.' | '.$cart['date'],
                'amount' => $cart['track']->validated_price,
                'quantity' => $cart['qty'],
                'date' => $cart['date'],
                'pickup' => $pickup['name'] ?? null,
                'pickup_id' => $pickup['id'] ?? null,
                'data_source' => $cart['track']->data_source,
                // 'dropoff' => $dropoff?->name,
                // 'dropoff_id' => $dropoff?->id,
            ]);

            if ($cart['track']->data_source != null) {
                AsyncService::async(function () use ($item) {
                    EkajayaService::order($item);
                });
            }

            // update every track ordered pending
            $track = FastboatTrack::find($trackId);
            FastboatTrack::updateTrackUsage($track, $cart['date'], $cart['qty']);

            // insert every person in order to every item
            foreach ($this->persons as $index => $person) {
                $item->passengers()->create([
                    'customer_id' => $index == 0 ? $customer->id : null,
                    'nation' => $person['nation'],
                    'national_id' => $person['national_id'],
                    'name' => $person['name'],
                    'type' => $person['type'],
                ]);
            }
        }

        if($pickup != null) {
            $date = collect($this->carts)->value('date');
            $order->items()->create([
                'entity_order' => CarRental::class,
                'entity_id' => $pickup['car']['id'],
                'description' => 'Pickup: '.$pickup['name'].'| '.$date,
                'amount' => $pickup['car']['price'],
                'quantity' => 1,
                'date' => $date,
            ]);
        }

        // insert promo
        foreach ($this->promos as $promo) {
            $order->promos()->create([
                'promo_id' => $promo['id'],
                'promo_code' => $promo['code'],
                'promo_amount' => $promo['amount'],
            ]);
            if ($promo['type'] == '4') {
                FreeTicketPromo::create([
                    'codition_type' => $promo['type'],
                    'amount' => $promo['amount'],
                ]);
            }
        }

        // send email for payment purpose
        AsyncService::async(function () use ($customer, $order) {
            Mail::to($customer->email)->send(new OrderPayment($order));
        });

        // redirect to payment
        DB::commit();

        session()->forget(['persons', 'contact', 'dropoff', 'carts', 'pickup']);

        return redirect()->route('customer.process-payment', $order);
    }

    public function applyPromos()
    {
        $dates = [];
        $qty = collect($this->carts)->value('qty');
        collect($this->carts)->map(function ($cart) use (&$dates) {
            $this->total += $cart['track']->validated_price * $cart['qty'];
            $this->total_payed += $cart['track']->validated_price * $cart['qty'];
            $dates[] = $cart['date'];
        });

        if ($this->pickupSelected != null) {
            $this->total += $this->pickupSelected['car']['price'];
            $this->total_payed += $this->pickupSelected['car']['price'];
        }

        $promos = Promo::where([
            'is_active' => Promo::PROMO_ACTIVE,
        ])
        ->where(function ($query) {
            $query->whereDate('available_start_date', '<=', now())
                ->whereDate('available_end_date', '>=', now());
        })
        ->orwhere(function ($query) {
            $query->whereNull('available_start_date')
            ->whereNull('available_end_date');
        })
        ->where(function ($query) use ($dates) {
            if (count($dates) > 0) {
                $query->where('order_start_date', '<=', $dates[0])
                    ->whereDate('order_end_date', '>=', $dates[0]);
            }
        })->orwhere(function ($query) {
            $query->whereNull('order_start_date')
                ->whereNull('order_end_date');
        })
        ->OrWhere(function ($query) {
            $query->whereNotNull('condition_type');
        })
        ->leftJoin('order_promos', 'promo_id', '=', 'promos.id')
        ->leftJoin('orders', 'orders.id', '=', 'order_promos.order_id')
        ->select('promos.*', DB::Raw('Count(promo_id) as used_promo,customer_id'))
        ->groupBy('promos.id')
        ->get();
       

        foreach ($promos as $promokey => $promo) {
            switch ($promo->condition_type) {
                case 2:
                    $datetime1 = new DateTime($promo->available_start_date);
                    $datetime2 = new DateTime($dates[0]);
                    
                    if ($datetime1->modify('-'.$promo->ranges_day.' day') <= $datetime2) {
                        unset($promos[$promokey]);
                    }
                    break;
                case 3:
                    $dateorder_start_date = new DateTime($promo->order_start_date);
                    $datetime2 = new DateTime($dates[0]);
                    if ($dateorder_start_date->modify('-'.$promo->ranges_day.' day') >= $datetime2) {
                        unset($promos[$promokey]);
                    }
                    break;
                default : 
                    if($promo->available_start_date!='0000-00-00'||$promo->order_start_date!='0000-00-00'){
                        $dateaveil=new DateTime($promo->available_start_date);
                        $dateOrder=new DateTime($promo->order_start_date);
                        $datetime2 = new DateTime($dates[0]);
                        if ($dateaveil > $datetime2||$dateOrder>$datetime2) {
                            unset($promos[$promokey]);
                        }
                    }
                    
            }
        }

        foreach ($promos as $promokey => $promo) {
            $isPercent = false;
            $namedic = '';
            if ($promo->order_perday_limit < $promo->used_promo ||
                    (Auth::guard('customer')->user() != null &&
                        Auth::guard('customer')->user()->id == $promo->id &&
                        $promo->user_perday_limit < $promo->used_promo)
            ) {
                unset($promos[$promokey]);
            } else {
                if ($promo->condition_type != 4) {
                    $mod = 1;
                    if ($promo->condition_type == 1) {
                        if ($qty % $promo->amount_buys == 0) {
                            $mod = $qty / $promo->amount_buys;
                        }
                    }

                    if ($promo->discount_type == Promo::TYPE_PERCENT) {
                        $isPercent = true;
                        $amount = ($this->total * $promo->discount_amount / 100) * $mod;
                    } else {
                        $amount = $promo->discount_amount * $mod;
                    }
                    $this->discount += $amount;

                    $namedic = $promo->name.' ( disc. '.$promo->discount_amount.($isPercent ? '% )' : ' )');

                } else {
                    $namedic = $promo->name.' ( Free Ticket. '.$promo->amount_tiket.')';
                }
                $this->promos[] = [
                    'id' => $promo->id,
                    'code' => $promo->code,
                    'name' => $namedic,
                    'amount' => $amount ?? 0,
                    'type' => $promo->condition_type,
                    'order_start_date' => $promo->order_start_date,
                    'ranges_day' => $promo->ranges_day,
                ];
            }
        }
        dd($promos);
        $this->total_payed = $this->total_payed - $this->discount;
    }

    public function updatingPickup($value)
    {
        $this->pickupSelected = collect($this->pickups)->where('name', $value)->first()->toArray();
        session(['pickup' => $this->pickupSelected]);
    }
}
