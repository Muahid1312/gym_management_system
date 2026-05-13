<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'member_id',
        'payment_id',
        'amount_paid',
        'remaining_balance',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
