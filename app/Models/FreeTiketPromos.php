<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeTiketPromos extends Model
{
    protected $fillable = [
        'codition_type',
        'amount',
        'range_days',
        'end_date'
    ];
}
