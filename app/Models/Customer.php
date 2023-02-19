<?php

namespace App\Models;

use App\Models\Traits\CascadeSoftDeletes;
use App\Models\Traits\UserTrackable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory, HasUuids, UserTrackable, SoftDeletes, CascadeSoftDeletes;

    const DEACTIVE = 0;
    const ACTIVE = 1;
    
    protected $cascadeDeletes = [];

    protected $fillable = [
        "name",
        "email",
        "phone",
        "password",
        "address",
        "nation",
        "remember_token",
        "reset_token",
        "is_active",
        "email_varified_at"
    ];

    public function orders()
    {
        return $this->hasMany(FastboatOrder::class);
    }
}
