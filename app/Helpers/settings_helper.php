<?php

use App\Models\SiteSetting;

if (!function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        return SiteSetting::get($key, $default);
    }
}

if (!function_exists('format_phone')) {
    function format_phone(?string $phone): string
    {
        return preg_replace('/[^0-9+]/', '', (string)$phone);
    }
}

if (!function_exists('safe_url')) {
    function safe_url(?string $url): string
    {
        if (empty($url) || $url === '#') {
            return '#';
        }
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, 'tel:') || str_starts_with($url, 'mailto:')) {
            return $url;
        }
        return url($url);
    }
}


