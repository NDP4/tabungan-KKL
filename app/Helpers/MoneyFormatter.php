<?php

namespace App\Helpers;

class MoneyFormatter
{
    public static function format(int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    public static function percentage(int $amount, int $total): float
    {
        if ($total === 0) {
            return 0;
        }
        return round(($amount / $total) * 100, 2);
    }

    public static function formatCompact(int $amount): string
    {
        if ($amount >= 1000000) {
            return 'Rp ' . number_format($amount / 1000000, 1, ',', '.') . ' Jt';
        }
        if ($amount >= 1000) {
            return 'Rp ' . number_format($amount / 1000, 1, ',', '.') . ' Rb';
        }
        return self::format($amount);
    }

    public static function parse(string $amount): int
    {
        $cleanString = preg_replace('/[^0-9]/', '', $amount);
        return (int) $cleanString;
    }
}
