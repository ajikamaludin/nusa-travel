<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\FastboatDropoff;
use App\Models\FastboatTrack;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;

// TODO: need to handle if user already login, provide contact automatily , if profile not compate in NIK, update the customers too
class FastboatCart extends Component
{
    public $show = true;

    public $carts = [];

    public $contact = [];

    public $persons = [];

    public $showContact = false;

    public $dropoffs = [];
    
    public $dropoff;

    public $validContact = false;

    public $isAllValid = false;

    public $view = 1;

    public $total = 0;

    public $promos = [];

    public $discount = 0;

    public function mount() 
    {
        $this->contact = session()->get('contact', []);
        if($this->contact != []) {
            $this->validContact = true;
        }
        $this->persons = session()->get('persons', []);
        $this->dropoff = session()->get('dropoff');
        $this->isAllValid = $this->checkAllValid();

        $this->dropoffs = FastboatDropoff::orderBy('name', 'asc')->get();
    }

    public function booted()
    {
        $carts = session()->get('carts') ?? [];
        $carts = collect($carts)->filter(function ($cart) {
            if(array_key_exists('fastboat_cart', $cart)) {
                return $cart;
            }
        });

        $tracks = FastboatTrack::with(['destination', 'source', 'group.fastboat'])->whereIn('id', $carts->keys())->get();
        $this->carts = $carts->map(function ($cart, $key) use ($tracks) {
            $cart['track'] = $tracks->where('id', $key)->first();
            if(! property_exists($this, 'showPerson_1')) {
                foreach(range(1, $cart['qty']) as $i => $q) {
                    $this->{"showPerson_$i"} = false;
                }
            }

            return $cart;
        });

        if(count($this->carts) > 0 && count($this->persons) == 0) {
            $qty = collect($this->carts)->value('qty');
            foreach(range(0, $qty - 1) as $i) {
                $this->persons[$i] = [];
            }
        }
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

        if($validate->fails()) {
            foreach($validate->messages()->toArray() as $name => $err) {
                $this->addError($name, $err);
            }

            return;
        }

        $person = $this->persons[0] ?? [];
        if($person != [] && $person['name'] == $this->contact['name']) {
            $this->persons[0] = $this->contact;
        }

        $this->showContact = false;
        $this->validContact = true;
        $this->isAllValid = $this->checkAllValid();
    }

    public function addContactToPerson()
    {
        $this->persons[0] = $this->contact;

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

        if($validate->fails()) {
            foreach($validate->messages()->toArray() as $name => $err) {
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
            'dropoff' => $this->dropoff,
        ]);

        collect($this->carts)->map(function ($cart) {
            $this->total += $cart['track']->price * $cart['qty'];
        });

        // TODO: search promo here
        // aplied to $this->promos
        // total of cust to $this->discount;

        $this->view = 2;
    }

    public function payment()
    {
        DB::beginTransaction();
        $customer = Customer::hardSearch(
            $this->contact['phone'],
            $this->contact['national_id'],
            $this->contact['email'],
            [
                'name' => $this->contact['name'],
                'nation' => $this->contact['nation'],
            ]
        );

        $dropoff = FastboatDropoff::where('name', $this->dropoff)->first();

        // create order
        $order = Order::create([
            'order_code' => Order::generateCode(),
            'customer_id' => $customer->id,
            'total_amount' => $this->total,
            'total_discount' => $this->discount,
            'order_type' => Order::TYPE_ORDER,
            'date' => now(),
        ]);

        // insert items -> insert passengers
        foreach($this->carts as $trackId => $cart) {
            // TODO : insert fastboat_track_order_capacities 
            $item = $order->items()->create([
                'entity_order' => $cart['type'],
                'entity_id' => $trackId,
                'description' => $cart['track']->source->name . ' - '.$cart['track']->destination->name . ' | ' . $cart['date'],
                'amount' => $cart['track']->price,
                'quantity' => $cart['qty'],
                'date' => $cart['date'],
                'dropoff' => $dropoff?->name,
                'dropoff_id' => $dropoff?->id
            ]);

            foreach($this->persons as $index => $person) {
                $item->passengers()->create([
                    'customer_id' => $index == 0 ? $customer->id : null,
                    'nation' => $person['nation'],
                    'national_id' => $person['national_id'],
                    'name' => $person['name'],
                ]);
            }
        }

        // insert promo
        if(count($this->promos) > 0) {
            // TODO: insert promo
        } 

        // TODO: send email

        // redirect to payment
        DB::commit();

        session()->forget(['persons', 'contact', 'dropoff', 'carts']);

        return redirect()->route('customer.process-payment', $order);
    }
}