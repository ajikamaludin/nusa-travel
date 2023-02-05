<?php

namespace App\Models;

use App\Models\Traits\UserTrackable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelImage extends Model
{
    use HasFactory, UserTrackable, SoftDeletes, HasUuids;

    protected $fillable = [
        'related_model',
        'related_id',
        'file_id',
    ];
}
