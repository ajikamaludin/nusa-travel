<?php

namespace App\Http\Livewire;

use App\Models\FastboatTrack;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FastboatItem extends Component
{
    public $track;
    public $ordered;
    public $date;

    public function render()
    {
        return view('livewire.fastboat-item');
    }

    public function addCart()
    {
        if(Auth::guard('customer')->check()) {
            $this->user();
        } else {
            $this->guest();
        }

        $this->emit('addCart');
    }

    public function guest() 
    {
        $carts = session('carts') ?? [];
        
        if(count($carts) > 0) {
            try{
                $isExists = $carts[$this->track->id];
                if($isExists != null) {
                    $carts[$this->track->id]['qty'] += 1;
                }
            } catch (\Exception $e) {
                $carts = array_merge($carts, [$this->track->id => ['qty' => 1, 'type' => FastboatTrack::class, 'date' => $this->date]]);
            }
        } else {
            $carts = [$this->track->id => ['qty' => 1, 'type' => FastboatTrack::class, 'date' => $this->date]];
        }
        
        session(['carts' => $carts]);
        return $carts;
    }

    public function user()
    {
        $cart = Order::where([
            ['customer_id', '=', auth('customer')->user()->id],
            ['order_type', '=', Order::TYPE_CART]
        ])->with(['items'])->first();

        // check is usert already has cart
        if($cart != null) {
            $item = $cart->items->where('entity_id', $this->track->id)->first();
            if($item != null) {
                $item->update(['quantity' => $item->quantity + 1]);
            } else {
                $cart->items()->create([
                    "entity_order" => FastboatTrack::class,
                    "entity_id" => $this->track->id,
                    "description" => "",
                    "amount" => $this->track->price,
                    "quantity" => 1,
                    "date" => $this->date
                ]);
            }
        } else {
            $cart = Order::create([
                "order_code" => Order::generateCode(),
                "customer_id" => auth('customer')->user()->id,
                "order_type" => Order::TYPE_CART,
            ]);
            $cart->items()->create([
                "entity_order" => FastboatTrack::class,
                "entity_id" => $this->track->id,
                "description" => "",
                "amount" => $this->track->price,
                "quantity" => 1,
                "date" => $this->date
            ]);
        }

        $carts = [];
        foreach($cart->items()->get() as $item) {
            $carts[$item['entity_id']] = ['qty' => $item['quantity'], 'type' => FastboatTrack::class, 'date' => $this->date];
        }

        return $carts;
    }
}
