<?php

namespace App\Models;

use App\Models\Traits\UserTrackable;
use App\Services\DeeplService;
use App\Services\GeneralService;
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

    public function translate()
    {
        return $this->hasMany(Page::class, 'original_id');
    }

    public function getTranslate()
    {
        $locale = GeneralService::getLocale();
        if ($locale != null) {
            $page = $this->translate()->where('lang', $locale)->first();
            if ($page == null) {
                DeeplService::translatePage($this);
                $page = $this->translate()->where('lang', $locale)->first();
            }
            return $page;
        }
        return $this;
    }
}
