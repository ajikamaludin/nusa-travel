<?php

namespace App\Http\Livewire;

use App\Models\FastboatTrack;
use Livewire\Component;

class FastboatCart extends Component
{
    public $show = true;

    public $carts = [];

    public function booted()
    {
        $carts = session()->get('carts') ?? [];
        if(count($carts) <= 0) {
            return redirect('home.index');
        }

        $carts = collect($carts)->filter(function ($cart, $key) {
            if(array_key_exists('fastboat_cart', $cart)) {
                return $cart;
            }
        });

        $tracks = FastboatTrack::with(['destination', 'source', 'group.fastboat'])->whereIn('id', $carts->keys())->get();
        $this->carts = $carts->map(function ($cart, $key) use ($tracks) {
            $cart['track'] = $tracks->where('id', $key)->first();
            return $cart;
        });
    }

    public function render()
    {
        return view('livewire.fastboat-cart');
    }
    
    public function toggle()
    {
        $this->show = !$this->show;
    }

}
