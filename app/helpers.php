<?php

use App\Helpers\MoneyFormatter;

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
