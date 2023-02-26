<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\TourPackage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PackageItem extends Component
{
    public $package;
    public $quantity;
    public $date;
    public $total;
    public $price;

    public function mount() 
    {
        $this->date = now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.package-item');
    }

    public function addCart()
    {
        $this->quantity = 1;
        $this->checkTotal();
    }

    public function increment()
    {
        $this->quantity += 1;
        $this->checkTotal();
    }

    public function decrement()
    {
        $this->quantity -= 1;
        $this->checkTotal();
    }

    public function checkTotal()
    {
        $prices = $this->package->prices;
        if($prices->count() > 0) {
            foreach($prices as $price) {
                if($this->quantity >= $price->quantity) {
                    $this->price = $price->price;
                }
            }
        } else {
            $this->price = $this->package->price;
        }
        $this->total = $this->price * $this->quantity;
    }

    public function checkout()
    {
        if(Auth::guard('customer')->check()) {
            $this->addUser();
        } else {
            $this->addGuest();
        }

        redirect()->route('customer.cart');
    }

    public function addUser()
    {
        $cart = Order::where([
            ['customer_id', '=', auth('customer')->user()->id],
            ['order_type', '=', Order::TYPE_CART]
        ])->with(['items'])->first();

        // check is usert already has cart
        if($cart != null) {
            $item = $cart->items->where('entity_id', $this->package->id)->first();
            if($item != null) {
                $item->update([
                    'quantity' => $this->quantity,
                    "amount" => $this->price,
                    "date" => $this->date
                ]);
            } else {
                $cart->items()->create([
                    "entity_order" => TourPackage::class,
                    "entity_id" => $this->package->id,
                    "description" => $this->package->order_detail,
                    "amount" => $this->price,
                    "quantity" => $this->quantity,
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
                "entity_order" => TourPackage::class,
                "entity_id" => $this->package->id,
                "description" => $this->package->order_detail,
                "amount" => $this->price,
                "quantity" => $this->quantity,
                "date" => $this->date
            ]);
        }
    }

    public function addGuest()
    {
        $carts = session('carts') ?? [];
        
        if(count($carts) > 0) {
            try{
                $isExists = $carts[$this->package->id];
                if($isExists != null) {
                    $carts[$this->package->id] = [
                        'qty' => $this->quantity, 
                        'type' => TourPackage::class, 
                        'date' => $this->date,
                        'price' => $this->price,
                    ];
                }
            } catch (\Exception $e) {
                $carts = array_merge($carts, [
                    $this->package->id => [
                        'qty' => $this->quantity, 
                        'type' => TourPackage::class, 
                        'date' => $this->date,
                        'price' => $this->price,
                    ]
                ]);
            }
        } else {
            $carts = [$this->package->id => [
                'qty' => $this->quantity, 
                'type' => TourPackage::class, 
                'date' => $this->date,
                'price' => $this->price,
            ]];
        }
        
        session(['carts' => $carts]);
    }
}
