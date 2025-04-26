<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['group', 'key', 'value'];

    public static function getSettings($key = null, $default = null)
    {
        if ($key) {
            return static::where('key', $key)->first()?->value ?? $default;
        }

        return static::all()
            ->groupBy('group')
            ->map(function ($group) {
                return $group->pluck('value', 'key');
            });
    }

    public static function setSettings($key, $value)
    {
        static::clearCache();

        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    protected static function clearCache()
    {
        Cache::forget('settings');
        // Clear all cached setting keys
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget('setting.' . $setting->key);
        }
    }

    protected static function booted()
    {
        static::saved(function () {
            static::clearCache();
        });

        static::deleted(function () {
            static::clearCache();
        });
    }
}
