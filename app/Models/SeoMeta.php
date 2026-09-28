<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    protected $table = 'seo_meta';

    protected $fillable = [
        'route_name',
        'url_path',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'twitter_image',
    ];

    public static function forPath(string $path): ?self
    {
        return static::where('url_path', $path)->orWhere('url_path', '/' . ltrim($path, '/'))->first();
    }
}
