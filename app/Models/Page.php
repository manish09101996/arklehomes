<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'hero_badge',
        'hero_image',
        'hero_video_url',
        'content',
        'is_published',
        'order',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('order');
    }

    public function visibleSections(): HasMany
    {
        return $this->hasMany(PageSection::class)->where('is_visible', true)->orderBy('order');
    }
}
