<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Order;
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

    public $isAuth = false;

    protected $rules = [
        'name' => 'required|string|max:255|min:3',
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20',
        'nation' => 'required|string',
        'national_id' => 'required|numeric',
        'email' => 'required|email',
    ];

    public function mount()
    {
        $this->isAuth = auth('customer')->check();
        $this->updateTotal();
    }

    public function render()
    {
        return view('livewire.cart');
    }

    public function submit()
    {
        if (! $this->isAuth) {
            $this->validate();
            $order = $this->createOrder();
        } else {
            $order = Order::where([
                ['customer_id', '=', auth('customer')->user()->id],
                ['order_type', '=', Order::TYPE_CART],
            ])->first();

            $order->update([
                'total_amount' => $this->total,
                'order_type' => Order::TYPE_ORDER,
                'date' => now(),
            ]);
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
        })->toArray();
        $this->updateCart();
    }

    public function decrementQty($id)
    {
        $this->carts = collect($this->carts)->map(function ($cart) use ($id) {
            if ($id === $cart['id'] && $cart['qty'] != 1) {
                $cart['qty'] -= 1;
            }

            return $cart;
        })->toArray();
        $this->updateCart();
    }

    public function removeItem($id)
    {
        $this->carts = collect($this->carts)->filter(function ($cart) use ($id) {
            return $cart['id'] != $id;
        })->all();
        $this->updateCart();

        if (count($this->carts) <= 0) {
            redirect()->route('home.index');
        }
    }

    public function updateCart()
    {
        if ($this->isAuth) {
            $order = Order::where([
                ['customer_id', '=', auth('customer')->user()->id],
                ['order_type', '=', Order::TYPE_CART],
            ])->with(['items'])->first();

            $order->items()->delete();

            foreach ($this->carts as $cart) {
                $order->items()->create([
                    'entity_order' => $cart['type'],
                    'entity_id' => $cart['id'],
                    'amount' => $cart['price'],
                    'quantity' => $cart['qty'],
                    'date' => $cart['date'],
                ]);
            }
        } else {
            session(['carts' => $this->carts]);
        }
        $this->updateTotal();
    }

    public function updateTotal()
    {
        $this->total = 0;
        foreach ($this->carts as $cart) {
            $this->total += ($cart['qty'] * $cart['price']);
        }
    }

    public function createOrder()
    {
        $phone = str_replace([' ', '+'], ['', ''], $this->phone);
        $customers = [
            Customer::withTrashed()->where('national_id', $this->national_id)->first(),
            Customer::withTrashed()->where('email', $this->email)->first(),
            Customer::withTrashed()->where('phone', 'like', "%$phone%")->first(),
        ];

        $customer = collect($customers)->filter(function ($v) {
            return $v != null;
        });

        if (count($customer) <= 0) {
            $customer = Customer::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'nation' => $this->nation,
                'is_active' => Customer::DEACTIVE,
                'national_id' => $this->national_id,
                'password' => bcrypt(Str::random(10)),
            ]);
        } else {
            $customer = $customer->first();
        }

        DB::beginTransaction();
        $order = Order::create([
            'order_code' => Order::generateCode(),
            'customer_id' => $customer->id,
            'total_amount' => $this->total,
            'order_type' => Order::TYPE_ORDER,
            'date' => now(),
        ]);

        foreach ($this->carts as $cart) {
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
