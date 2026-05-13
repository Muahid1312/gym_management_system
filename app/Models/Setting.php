<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = ['key', 'value', 'type'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get a setting value by key, with automatic type casting.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        return match ($setting->type) {
            'integer' => (int) $setting->value,
            'boolean' => $setting->value === 'true' || $setting->value === '1',
            'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }

    /**
     * Set a setting value by key.
     */
    public static function put(string $key, mixed $value, string $type = 'string'): void
    {
        $actualValue = match ($type) {
            'boolean' => $value ? 'true' : 'false',
            'json' => json_encode($value),
            default => (string) $value,
        };

        static::updateOrCreate(
            ['key' => $key],
            ['value' => $actualValue, 'type' => $type]
        );
    }
}
