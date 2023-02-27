<?php

namespace App\Models;

class Faq extends Model
{
    protected $cascadeDeletes = [];

    protected $fillable = [
        "question",
        "answer",
        "order",
    ];
}
