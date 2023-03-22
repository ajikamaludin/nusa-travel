<?php

namespace App\Models;

use App\Models\Traits\UserTrackable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, UserTrackable, SoftDeletes, HasUuids;

    protected $fillable = [
        'key',
        'title',
        'body',
        'meta_tag',
        'attribute',
        'flag',
        'original_id',
        'lang',
    ];
}
