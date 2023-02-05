<?php

namespace App\Models;

use App\Models\Traits\UserTrackable;
use CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory, HasUuids, UserTrackable, SoftDeletes, CascadeSoftDeletes;

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
        "email_verified_at"
    ];
}
