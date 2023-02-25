<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class Cart extends Component
{
    public $carts;
    public $total;

    public $name;
    public $phone;
    public $email;
    public $nation;
    public $national_id;

    protected $rules = [
        'name' => 'required|string|max:255|min:3',
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20',
        'nation' => 'required|string',
        'national_id' => 'required|numeric',
        'email' => 'required|email'
    ];

    public function mount() 
    {
        $this->updateTotal();
    }
    public function render()
    {
        return view('livewire.cart');
    }

    public function submit()
    {
        if(!Auth::guard('customer')->check()) {
            $this->validate();
            $order = $this->createOrder();
        }

        // redirect to payment
        redirect()->route('customer.process-payment', $order);
    }

    public function incrementQty($id)
    {
        $this->carts = collect($this->carts)->map(function ($cart) use ($id) {
            if ($id === $cart['id']) {
                $cart['qty'] += 1;
            }
            return $cart;
        });
        $this->updateCart();
    }

    public function decrementQty($id)
    {
        $this->carts = collect($this->carts)->map(function ($cart) use ($id) {
            if ($id === $cart['id'] && $cart['qty'] != 1) {
                $cart['qty'] -= 1;
            }
            return $cart;
        });
        $this->updateCart();
    }

    public function removeItem($id)
    {
        $this->carts = collect($this->carts)->filter(function ($cart) use ($id) {
            return $cart['id'] != $id;
        })->all();
        $this->updateCart();

        if(count($this->carts) <= 0) {
            redirect()->route('home.index');
        }
    }

    public function updateCart()
    {
        if(Auth::guard('customer')->check()){
            // 
        } else {
            $carts = [];
            foreach($this->carts as $cart) {
                $carts = array_merge($carts, [
                    $cart['id'] => ['qty' => $cart['qty'], 'type' => $cart['type'], 'date' => $cart['date']]
                ]);
            }
            session(['carts' => $carts]);
        }
        $this->updateTotal();
    }

    public function updateTotal()
    {
        $this->total = 0;
        foreach($this->carts as $cart) {
            $this->total += ($cart['qty'] * $cart['price']);
        }
    }

    public function createOrder()
    {
        $phone = str_replace([' ', '+'], ['', ''], $this->phone);
        $customers = [
            Customer::where('national_id', $this->national_id)->first(),
            Customer::where('email', $this->email)->first(),
            Customer::where('phone', 'like', "%$phone%")->first(),
        ];
        
        $customer = array_filter($customers, function($v) {
            return $v != null;
        });

        if(count($customer) <= 0) {
            $customer = Customer::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'nation' => $this->nation,
                'is_active' => Customer::DEACTIVE,
                'national_id' => $this->national_id,
                'password' => bcrypt(Str::random(10))
            ]);
        } else {
            $customer = $customer[0];
        }

        DB::beginTransaction();
        $order = Order::create([
            'order_code' => Order::generateCode(),
            'customer_id' => $customer->id,
            'total_amount' => $this->total,
            'order_type' => Order::TYPE_CART,
        ]);

        foreach($this->carts as $cart) {
            $order->items()->create([
                'entity_order' => $cart['type'],
                'entity_id' => $cart['id'],
                'description' => $cart['name'],
                'amount' => $cart['price'],
                'quantity' => $cart['qty'],
                'date' => $cart['date'],
            ]);
        }
        DB::commit();
        session()->remove('carts');

        // TODO: send email that order created ans has a link todo payment 

        return $order;
    }
}
