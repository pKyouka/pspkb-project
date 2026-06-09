<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'setting_key',
        'setting_value',
    ];

    /**
     * Get a setting value by key
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = static::where('setting_key', $key)->first();
        return $setting ? $setting->setting_value : $default;
    }

    /**
     * Set a setting value by key
     */
    public static function setValue(string $key, mixed $value): static
    {
        return static::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value]
        );
    }

    /**
     * Get all settings as key-value array
     */
    public static function getAll(): array
    {
        return static::pluck('setting_value', 'setting_key')->toArray();
    }

    /**
     * Get cached setting value
     */
    public static function cached(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting_{$key}", 3600 * 24, function () use ($key, $default) {
            return static::getValue($key, $default);
        });
    }

    /**
     * Clear settings cache
     */
    public static function clearCache(): void
    {
        $keys = static::pluck('setting_key');
        foreach ($keys as $key) {
            Cache::forget("setting_{$key}");
        }
    }
}
