<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Seo extends Model
{
    protected $fillable = [
        'seoable_type',
        'seoable_id',
        'meta_title',
        'meta_description',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'structured_data',
    ];

    protected $casts = [
        'structured_data' => 'array',
    ];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
