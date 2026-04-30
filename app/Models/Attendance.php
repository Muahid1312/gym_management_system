<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'check_in_time',
        'qr_code',
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
