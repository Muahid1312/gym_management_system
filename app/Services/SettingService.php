<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    protected array $cache = [];

    public function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $this->cache)) {
            return $this->cache[$key];
        }

        $value = Setting::get($key, $default);
        $this->cache[$key] = $value;

        return $value;
    }

    public function set(string $key, mixed $value, string $type = 'string'): void
    {
        Setting::put($key, $value, $type);
        $this->cache[$key] = $this->castValue($type, $value);
    }

    public function all(array $defaults = []): array
    {
        $settings = [];

        foreach (Setting::all() as $setting) {
            $settings[$setting->key] = $this->castValue($setting->type, $setting->value);
        }

        return array_merge($defaults, $settings);
    }

    protected function castValue(string $type, mixed $value): mixed
    {
        return match ($type) {
            'integer' => (int) $value,
            'boolean' => $value === true || $value === 'true' || $value === '1',
            'json' => json_decode($value, true),
            default => $value,
        };
    }
}
