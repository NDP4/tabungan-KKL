<?php

use App\Helpers\MoneyFormatter;
use App\Models\Setting;

if (!function_exists('format_money')) {
    function format_money($amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('parse_money')) {
    function parse_money($amount): int
    {
        return MoneyFormatter::parse($amount);
    }
}

if (!function_exists('settings')) {
    function settings($key = null, $default = null)
    {
        return Setting::getSettings($key, $default);
    }
}

if (!function_exists('set_setting')) {
    function set_setting($key, $value, $group = 'website')
    {
        return Setting::setSettings($key, $value);
    }
}
