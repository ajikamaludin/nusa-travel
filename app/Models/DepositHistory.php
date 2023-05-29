<?php

namespace App\Models;

class DepositHistory extends Model
{
    const VALID = 1;
    const INVALID = 0;

    protected $fillable = [
        'customer_id',
        'debit',
        'credit',
        'description',
        'is_valid',
        'proof_image',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }
}
