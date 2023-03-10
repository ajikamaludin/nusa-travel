<?php

namespace App\Http\Livewire;

use App\Models\FastboatTrack;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class FastboatCart extends Component
{
    // TODO: need to handle if user already login, provide contact automatily , if profile not compate in NIK, update the customers too
    public $show = true;

    public $carts = [];

    public $contact = [];

    public $persons = [];

    public $showContact;
    public $validContact = false;

    public $isAllValid = false;

    public $title = 'Fill In Details';

    public function booted()
    {
        $carts = session()->get('carts') ?? [];
        if(count($carts) <= 0) {
            return redirect('home.index');
        }

        $carts = collect($carts)->filter(function ($cart) {
            if(array_key_exists('fastboat_cart', $cart)) {
                return $cart;
            }
        });

        $tracks = FastboatTrack::with(['destination', 'source', 'group.fastboat'])->whereIn('id', $carts->keys())->get();
        $this->carts = $carts->map(function ($cart, $key) use ($tracks) {
            $cart['track'] = $tracks->where('id', $key)->first();
            if(!property_exists($this, 'showPerson_1')) {
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
        return $this->validContact && !in_array([], $this->persons);
    }

    public function continue()
    {
        // 
    }
}
