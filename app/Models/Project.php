<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'location',
        'short_description',
        'full_description',
        'status',
        'completion_date',
        'client_name',
        'project_type',
        'bedrooms',
        'bathrooms',
        'garage',
        'land_size',
        'house_size',
        'year',
        'featured_image',
        'is_featured',
        'is_published',
        'order',
        'link_type',
        'external_url',
        'open_new_tab',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'og_image',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'open_new_tab' => 'boolean',
        'completion_date' => 'date',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'garage' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('order');
    }

    public function features(): HasMany
    {
        return $this->hasMany(ProjectFeature::class)->orderBy('order');
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProjectSpecification::class)->orderBy('order');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    /**
     * Determine if project redirects externally.
     */
    public function getIsExternalAttribute(): bool
    {
        return $this->link_type === 'external' && !empty($this->external_url);
    }

    /**
     * Dynamic destination URL attribute.
     */
    public function getDestinationUrlAttribute(): string
    {
        if ($this->is_external) {
            return $this->external_url;
        }

        return url('/projects/' . $this->slug);
    }

    /**
     * Link target attribute.
     */
    public function getLinkTargetAttribute(): string
    {
        if ($this->is_external && $this->open_new_tab) {
            return '_blank';
        }

        return '_self';
    }

    /**
     * Link rel attribute for security on external links.
     */
    public function getLinkRelAttribute(): ?string
    {
        if ($this->link_target === '_blank') {
            return 'noopener noreferrer';
        }

        return null;
    }

    /**
     * Fallback featured image URL helper.
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            if (str_starts_with($this->featured_image, 'http://') || str_starts_with($this->featured_image, 'https://')) {
                return $this->featured_image;
            }
            return asset('storage/' . $this->featured_image);
        }

        return asset('images/projects/placeholder.jpg');
    }
}
