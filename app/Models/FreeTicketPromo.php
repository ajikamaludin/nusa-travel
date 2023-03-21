<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeTicketPromo extends Model
{
    protected $fillable = [
        'codition_type',
        'amount',
        'range_days',
        'end_date',
    ];
}
