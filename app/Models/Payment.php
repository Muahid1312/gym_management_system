<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'plan_id',
        'amount',
        'paid_at',
        'notes',
        'is_partial',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'is_partial' => 'boolean',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
