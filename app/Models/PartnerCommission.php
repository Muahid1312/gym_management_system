<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'payment_id',
        'member_id',
        'commission_percentage',
        'commission_amount',
        'is_paid',
        'paid_at',
    ];

    protected $casts = [
        'commission_percentage' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
