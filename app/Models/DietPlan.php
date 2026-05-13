<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'age',
        'weight',
        'height',
        'goal',
        'level',
        'plan_data',
    ];

    protected $casts = [
        'plan_data' => 'array',
        'weight' => 'decimal:2',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
