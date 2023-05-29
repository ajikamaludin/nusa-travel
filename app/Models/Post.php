<?php

namespace App\Models;

use App\Services\DeeplService;
use App\Services\GeneralService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $cascadeDeletes = [];

    const DRAFT = 0;

    const PUBLISH = 1;

    protected $fillable = [
        'slug',
        'title',
        'body',
        'meta_tag',
        'cover_image',
        'is_publish',
        'original_id',
        'lang',
        'created_by',
    ];

    protected $appends = ['publish', 'image_url', 'publish_at', 'date_for_human'];

    public function tags()
    {
        return $this->hasManyThrough(
            Tag::class,
            PostTag::class,
            'post_id',
            'id',
            'id',
            'tag_id'
        );
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class, 'related_model_id', 'id');
    }

    public function translate()
    {
        return $this->hasMany(Post::class, 'original_id');
    }

    protected function publish(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                self::DRAFT => 'Draft',
                self::PUBLISH => 'Publish',
            ][$this->is_publish],
        );
    }

    protected function publishAt(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->format('d-m-Y'),
        );
    }

    protected function dateForHuman(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->diffForHumans([
                'parts' => 4,
                'join' => ' ',
            ]),
        );
    }

    protected function publishAtHuman(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->format('d F Y'),
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset($this->cover_image),
        );
    }

    protected function shortDesc(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::substr(strip_tags($this->body), 0, 100),
        );
    }

    public function getTranslate()
    {
        $locale = GeneralService::getLocale();
        if ($locale != null) {
            $post = $this;
            if ($this->original_id == null) {
                $post = Post::where([
                    ['original_id', '=', $this->id],
                    ['lang', '=', $locale]
                ])->first();
                // handle unkhow url access
                // if ($post == null) {
                //     DeeplService::translatePost($this);
                //     $post = Post::where([
                //         ['original_id', '=', $this->id],
                //         ['lang', '=', $locale]
                //     ])->first();
                // }
                if ($post == null) {
                    $post = $this;
                }
            }
            return $post;
        }
        return $this;
    }
}
