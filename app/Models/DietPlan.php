<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'level',
        'plan_data',
    ];

    protected $casts = [
        'plan_data' => 'array',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
