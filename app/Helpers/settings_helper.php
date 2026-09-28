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
