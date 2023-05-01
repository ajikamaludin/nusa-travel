<?php

namespace App\Models;

use App\Models\Traits\CascadeSoftDeletes;
use App\Models\Traits\UserTrackable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Customer extends Authenticatable
{
    use HasFactory, HasUuids, UserTrackable, SoftDeletes, CascadeSoftDeletes;

    const DEACTIVE = 0;

    const ACTIVE = 1;

    const WNI = 'WNI';

    const WNA = 'WNA';

    const AGENT = 1;

    const CUSTOMER = 0;

    protected $cascadeDeletes = [];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'address',
        'nation',
        'remember_token',
        'reset_token',
        'is_active',
        'email_varified_at',
        'national_id',
        'is_agent',
        'token',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public static function hardSearch($phone, $national_id, $email, $data = []): Customer
    {
        $phone = str_replace([' ', '+'], ['', ''], $phone);
        $customers = [
            Customer::withTrashed()->where('national_id', $national_id)->first(),
            Customer::withTrashed()->where('email', $email)->first(),
            Customer::withTrashed()->where('phone', 'like', "%$phone%")->first(),
        ];

        $customer = collect($customers)->filter(function ($v) {
            return $v != null;
        });

        if (count($customer) <= 0) {
            $customer = Customer::create([
                'name' => $data['name'],
                'phone' => $phone,
                'email' => $email,
                'nation' => $data['nation'],
                'is_active' => Customer::DEACTIVE,
                'national_id' => $national_id,
                'password' => bcrypt(Str::random(10)),
            ]);
        } else {
            $customer = $customer->first();
        }

        return $customer;
    }

    public function tracksAgent()
    {
        return $this->hasMany(FastboatTrackAgent::class);
    }
}
