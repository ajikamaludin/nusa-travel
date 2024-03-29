<?php

namespace App\Http\Livewire;

use App\Mail\OrderPayment;
use App\Models\Customer;
use App\Models\Order;
use App\Services\AsyncService;
use App\Services\GeneralService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use WireUi\Traits\Actions;

class Cart extends Component
{
    use Actions;

    public $carts;

    public $total;

    public $name;

    public $phone;

    public $email;

    public $nation;

    public $national_id;

    public $isAuth = false;

    public $isFastboat = false;

    public $payments = [];

    public $selectedPayment = null;

    protected $rules = [
        'name' => 'required|string|max:255|min:3',
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9|max:20',
        'nation' => 'required|string',
        'national_id' => 'required|numeric',
        'email' => 'required|email',
    ];

    public function mount()
    {
        $this->payments = (new GeneralService)->getEnablePayment(auth()->user()?->id);
        $this->selectedPayment = count($this->payments) >= 1 ? $this->payments[0] : null;

        $this->isFastboat = $this->isFastboat();
        $this->isAuth = auth('customer')->check();
        $this->updateTotal();
    }

    public function render()
    {
        return view('livewire.cart');
    }

    public function submit()
    {
        if ($this->selectedPayment == null) {
            $this->dialog()->error('Warning !!!', 'Payment system disabled');

            return;
        }
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
                'payment_channel' => $this->selectedPayment['name'],
            ]);
        }

        // send email for payment purpose
        AsyncService::async(function () use ($order) {
            Mail::to($order->customer->email)->send(new OrderPayment($order));
        });

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
            redirect()->route('home.index', ['locale' => GeneralService::getLocale('en')]);
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
        $this->isFastboat = $this->isFastboat();
    }

    public function createOrder()
    {
        $customer = Customer::hardSearch(
            $this->phone,
            $this->national_id,
            $this->email,
            [
                'name' => $this->name,
                'nation' => $this->nation,
            ]
        );

        DB::beginTransaction();
        $order = Order::create([
            'order_code' => Order::generateCode(),
            'customer_id' => $customer->id,
            'total_amount' => $this->total,
            'order_type' => Order::TYPE_ORDER,
            'date' => now(),
            'payment_channel' => $this->selectedPayment['name'],
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

        return $order;
    }

    public function isFastboat()
    {
        $carts = session('carts') ?? [];

        if (count($carts) > 0) {
            $carts = collect($carts)->filter(function ($cart) {
                if (array_key_exists('fastboat_cart', $cart)) {
                    return $cart;
                }
            })->count();

            if ($carts > 0) {
                return true;
            }
        }

        return false;
    }

    public function setSelectedPayment($index)
    {
        $this->selectedPayment = $this->payments[$index];
    }
}
