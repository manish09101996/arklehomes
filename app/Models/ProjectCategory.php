<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'category_id')->orderBy('order');
    }

    public function publishedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'category_id')
            ->where('is_published', true)
            ->orderBy('order');
    }
}
