<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Cache key prefix.
     */
    const CACHE_PREFIX = 'settings_';
    const CACHE_ALL_KEY = 'settings_all';

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, $default = null)
    {
        $setting = Cache::rememberForever(self::CACHE_PREFIX . $key, function () use ($key) {
            return self::where('key', $key)->first();
        });

        if (!$setting) {
            return $default;
        }

        return self::castValue($setting->value, $setting->type);
    }

    /**
     * Set a setting value.
     */
    public static function set(string $key, $value, string $type = 'string', string $group = 'general'): self
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => self::encodeValue($value, $type),
                'type' => $type,
                'group' => $group,
            ]
        );

        Cache::forget(self::CACHE_PREFIX . $key);
        Cache::forget(self::CACHE_ALL_KEY);

        return $setting;
    }

    /**
     * Get all settings.
     */
    public static function getAllSettings(): array
    {
        return Cache::rememberForever(self::CACHE_ALL_KEY, function () {
            $settings = [];
            foreach (self::all() as $setting) {
                $settings[$setting->key] = self::castValue($setting->value, $setting->type);
            }
            return $settings;
        });
    }

    /**
     * Get settings by group.
     */
    public static function getGroup(string $group): array
    {
        $settings = [];
        foreach (self::where('group', $group)->get() as $setting) {
            $settings[$setting->key] = self::castValue($setting->value, $setting->type);
        }
        return $settings;
    }

    /**
     * Get public settings (for frontend).
     */
    public static function getPublicSettings(): array
    {
        $settings = [];
        foreach (self::where('is_public', true)->get() as $setting) {
            $settings[$setting->key] = self::castValue($setting->value, $setting->type);
        }
        return $settings;
    }

    /**
     * Cast value based on type.
     */
    protected static function castValue($value, string $type)
    {
        return match ($type) {
            'integer' => (int) $value,
            'boolean' => (bool) $value,
            'json' => json_decode($value, true),
            'file', 'string' => $value,
            default => $value,
        };
    }

    /**
     * Encode value for storage.
     */
    protected static function encodeValue($value, string $type): string
    {
        return match ($type) {
            'json' => json_encode($value),
            'boolean' => $value ? '1' : '0',
            default => (string) $value,
        };
    }

    /**
     * Clear all settings cache.
     */
    public static function clearCache(): void
    {
        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget(self::CACHE_PREFIX . $setting->key);
        }
        Cache::forget(self::CACHE_ALL_KEY);
    }

    /**
     * Scope for group.
     */
    public function scopeGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Scope for public settings.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}
