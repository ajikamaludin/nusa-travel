<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FastboatCart extends Component
{
    public $show = true;

    public function render()
    {
        return view('livewire.fastboat-cart');
    }
    
    public function toggle()
    {
        $this->show = !$this->show;
    }

}
