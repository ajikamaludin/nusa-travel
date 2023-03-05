<?php

namespace App\Models;

class Faq extends Model
{
    protected $fillable = [
        "question",
        "answer",
        "order",
    ];
}
