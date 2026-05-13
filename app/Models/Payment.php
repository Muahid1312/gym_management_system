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
        'partner_id',
        'payment_method',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'is_partial' => 'boolean',
        'amount' => 'decimal:2',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }

    public function commission()
    {
        return $this->hasOne(PartnerCommission::class);
    }
}
