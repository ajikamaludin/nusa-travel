<?php

namespace App\Http\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;

class Fastboat extends Component
{
    protected $listeners = [
        'changePassengers' => 'changePassenger',
        'changeInfants' => 'changeInfant',
        'changeOrigin' => 'changeOrigin',
        'changeDest' => 'changeDest',
        'changeDate' => 'changeDate',
        'changeRdate' => 'changeRdate',
    ];

    public $from;

    public $to;

    public $ways;

    public $date;

    public $rdate;

    public $passengers;

    public $infants;

    public function render()
    {
        return view('livewire.fastboat');
    }

    public function showAvailableRoute()
    {
        $this->emit('showAvailableRoute', [
            'from' => $this->from,
            'to' => $this->to,
            'ways' => $this->ways,
            'date' => $this->date,
            'rdate' => $this->rdate,
            'passengers' => $this->passengers,
            'infants' => $this->infants,
        ]);
    }

    public function changePassenger($value)
    {
        $this->passengers = $value;
    }

    public function changeInfant($value)
    {
        $this->infants = $value;
    }

    public function changeOrigin($value)
    {
        $this->from = $value;
    }

    public function changeDest($value)
    {
        $this->to = $value;
    }

    public function changeDate($value)
    {
        $this->date = $value;
    }

    public function changeRdate($value)
    {
        $this->rdate = $value;
    }
}
