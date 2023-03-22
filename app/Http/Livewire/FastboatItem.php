<?php

namespace App\Http\Livewire;

use App\Models\FastboatTrack;
use Livewire\Component;

class FastboatItem extends Component
{
    protected $listeners = [
        'changePassengers' => 'changePassengers',
        // 'changeDate' => 'changeDate',
        // 'changeRdate' => 'changeRdate',
    ];

    public $track;

    public $date;

    public $type;

    public $quantity;

    public $avalaible;

    public function booted()
    {
        $this->avalaible = $this->track->getCapacity($this->date);
    }

    public function render()
    {
        return view('livewire.fastboat-item', [
            'quantity' => $this->quantity,
        ]);
    }

    public function addCart()
    {
        $this->addToGuestCart();

        $this->emit('choosedDepartureFastboat', ['type' => $this->type, 'track_id' => $this->track->id]);

        $this->emit('addCart');
    }

    public function addToGuestCart()
    {
        $carts = session('carts') ?? [];

        if (count($carts) > 0) {
            // filter session cart only for fastboat and type not duplicate cause only have 1 and 2
            $carts = collect($carts)->filter(function ($cart) {
                if (array_key_exists('fastboat_cart', $cart) && $cart['fastboat_cart'] != $this->type) {
                    return $cart;
                }
            })->toArray();

            $carts = array_merge($carts, [
                $this->track->id => [
                    'qty' => $this->quantity,
                    'type' => FastboatTrack::class,
                    'date' => $this->date,
                    'fastboat_cart' => $this->type,
                ],
            ]);
        } else {
            $carts = [
                $this->track->id => [
                    'qty' => $this->quantity,
                    'type' => FastboatTrack::class,
                    'date' => $this->date,
                    'fastboat_cart' => $this->type,
                ],
            ];
        }

        session(['carts' => $carts]);
    }

    public function changePassengers($value)
    {
        $this->quantity = $value;
    }

    public function changeDate($value)
    {
        if ($this->type == 1) {
            $this->date = $value;
            $this->avalaible = $this->track->getCapacity($this->date);
        }
    }

    public function changeRdate($value)
    {
        if ($this->type == 2) {
            $this->date = $value;
            $this->avalaible = $this->track->getCapacity($this->date);
        }
    }
}
