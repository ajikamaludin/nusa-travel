<?php

namespace App\Models;

use App\Models\Traits\UserTrackable;
use CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends BaseModel{
    use HasFactory, UserTrackable, SoftDeletes, CascadeSoftDeletes;

}