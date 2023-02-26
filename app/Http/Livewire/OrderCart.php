<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderCart extends Component
{
    public $cart = 0;
    protected $listeners = ['addCart' => 'countCart'];

    public function mount()
    {
        $this->countCart();
    }

    public function render()
    {
        return view('livewire.order-cart');
    }

    public function countCart()
    {
        if(Auth::guard('customer')->check()) {
            $this->cart = $this->user();
        } else {
            $this->cart = $this->guest();
        }
    }

    public function guest() 
    {
        $carts = session('carts') ?? [];
        $count = 0;
        if($carts != []) {
            foreach($carts as $id => $value) {
                $count += $value['qty'];
            }
        }

        return $count;
    }

    public function user()
    {
        $cart = Order::where([
            ['customer_id', '=', auth('customer')->user()->id],
            ['order_type', '=', Order::TYPE_CART]
        ])->with(['items'])->first();

        $count = 0;
        if($cart != null) {
            $carts = [];
            foreach($cart->items as $item) {
                $carts[$item['entity_id']] = $item['quantity'];
            }

            $count = 0;
            foreach($carts as $id => $c) {
                $count += $c;
            }
        }
        return $count;
    }
}
