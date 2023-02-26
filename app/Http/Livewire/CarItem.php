<?php

namespace App\Http\Livewire;

use App\Models\CarRental;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CarItem extends Component
{
    public $car;
    public $date;

    public function render()
    {
        return view('livewire.car-item');
    }

    public function addCart()
    {
        if(Auth::guard('customer')->check()) {
            $this->user();
        } else {
            $this->guest();
        }

        // just redirect
        redirect()->route('customer.cart');
        // $this->emit('addCart');
    }

    public function guest() 
    {
        $carts = session('carts') ?? [];
        
        if(count($carts) > 0) {
            try{
                $isExists = $carts[$this->car->id];
                if($isExists != null) {
                    $carts[$this->car->id]['qty'] += 1;
                }
            } catch (\Exception $e) {
                $carts = array_merge($carts, [$this->car->id => ['qty' => 1, 'type' => CarRental::class, 'date' => $this->date]]);
            }
        } else {
            $carts = [$this->car->id => ['qty' => 1, 'type' => CarRental::class, 'date' => $this->date]];
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
            $item = $cart->items->where('entity_id', $this->car->id)->first();
            if($item != null) {
                $item->update(['quantity' => $item->quantity + 1]);
            } else {
                $cart->items()->create([
                    "entity_order" => CarRental::class,
                    "entity_id" => $this->car->id,
                    "description" => $this->car->order_detail,
                    "amount" => $this->car->price,
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
                "entity_order" => CarRental::class,
                "entity_id" => $this->car->id,
                "description" => $this->car->order_detail,
                "amount" => $this->car->price,
                "quantity" => 1,
                "date" => $this->date
            ]);
        }

        $carts = [];
        foreach($cart->items()->get() as $item) {
            $carts[$item['entity_id']] = ['qty' => $item['quantity'], 'type' => CarRental::class, 'date' => $this->date];
        }

        return $carts;
    }
}
