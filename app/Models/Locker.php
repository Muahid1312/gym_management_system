<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;

    protected $fillable = [
        'locker_number',
        'status',
    ];

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_OCCUPIED = 'occupied';
    public const STATUS_MAINTENANCE = 'maintenance';

    public static function statuses(): array
    {
        return [
            self::STATUS_AVAILABLE,
            self::STATUS_OCCUPIED,
            self::STATUS_MAINTENANCE,
        ];
    }

    public function assignments()
    {
        return $this->hasMany(LockerAssignment::class);
    }

    public function activeAssignment()
    {
        return $this->hasOne(LockerAssignment::class)->whereNull('returned_at');
    }
}
