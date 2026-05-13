<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LockerAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'locker_id',
        'member_id',
        'assigned_at',
        'expiry_date',
        'temporary',
        'returned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'expiry_date' => 'date',
        'temporary' => 'boolean',
        'returned_at' => 'datetime',
    ];

    public function locker()
    {
        return $this->belongsTo(Locker::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('returned_at');
    }
}
