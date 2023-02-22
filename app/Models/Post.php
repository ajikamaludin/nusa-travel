<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'is_publish'
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

    protected function publish(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                self::DRAFT => 'Draft',
                self::PUBLISH => 'Publish'
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
                'join' => ' '
            ]),
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset($this->cover_image),
        );
    }
}
