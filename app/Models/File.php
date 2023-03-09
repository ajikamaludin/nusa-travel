<?php

namespace App\Models;

use App\Models\Traits\UserTrackable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, UserTrackable, SoftDeletes, HasUuids;

    const NO_DISPLAY = 0;

    const MAIN_DISPLAY = 1;

    const SIDE1_DISPLAY = 2;

    const SIDE2_DISPLAY = 3;

    protected $fillable = [
        'name',
        'path',
        'show_on',
    ];

    protected $appends = ['path_url'];

    public function pathUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset($this->path),
        );
    }
}
