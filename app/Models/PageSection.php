<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $fillable = [
        'page_id',
        'section_type',
        'section_key',
        'badge',
        'title',
        'subtitle',
        'content',
        'image',
        'image_secondary',
        'video_url',
        'button_text',
        'button_url',
        'secondary_button_text',
        'secondary_button_url',
        'extra_data',
        'order',
        'is_visible',
    ];

    protected $casts = [
        'extra_data' => 'array',
        'is_visible' => 'boolean',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
