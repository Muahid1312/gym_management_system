<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'type',
        'commission_percentage',
        'is_active',
    ];

    protected $casts = [
        'commission_percentage' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function commissions()
    {
        return $this->hasMany(PartnerCommission::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get total earnings for this partner
     */
    public function getTotalEarnings(): float
    {
        return (float) $this->commissions()->sum('commission_amount');
    }

    /**
     * Get total paid earnings
     */
    public function getTotalPaidEarnings(): float
    {
        return (float) $this->commissions()
            ->where('is_paid', true)
            ->sum('commission_amount');
    }

    /**
     * Get total unpaid earnings
     */
    public function getTotalUnpaidEarnings(): float
    {
        return (float) $this->commissions()
            ->where('is_paid', false)
            ->sum('commission_amount');
    }

    /**
     * Mark commission as paid
     */
    public function markCommissionAsPaid(PartnerCommission $commission): void
    {
        $commission->update([
            'is_paid' => true,
            'paid_at' => now(),
        ]);
    }
}
