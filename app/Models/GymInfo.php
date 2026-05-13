<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GymInfo extends Model
{
    protected $table = 'gym_info';

    protected $fillable = [
        'gym_name',
        'address',
        'phone',
        'email',
        'logo_path',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the singleton instance (only one record should exist).
     */
    public static function getInstance(): self
    {
        return self::firstOrCreate(
            [],
            [
                'gym_name' => 'Gym Management System',
                'address' => '123 Main Street, City, State',
                'phone' => '+1 (000) 000-0000',
                'email' => 'contact@gym.local',
            ]
        );
    }

    /**
     * Get the logo URL.
     */
    public function getLogoUrl(): ?string
    {
        if (!$this->logo_path) {
            return null;
        }

        return asset('storage/' . $this->logo_path);
    }

    /**
     * Check if logo exists.
     */
    public function hasLogo(): bool
    {
        return !is_null($this->logo_path);
    }
}
