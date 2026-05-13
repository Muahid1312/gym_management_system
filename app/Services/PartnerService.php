<?php

namespace App\Services;

use App\Models\Partner;
use App\Models\Payment;
use App\Models\PartnerCommission;

class PartnerService
{
    /**
     * Calculate and create commission for a payment
     */
    public function calculateAndCreateCommission(Payment $payment): ?PartnerCommission
    {
        // Get partner from payment or member
        $partner = $payment->partner ?? $payment->member->partner;

        if (!$partner || !$partner->is_active) {
            return null;
        }

        $commissionAmount = $this->calculateCommissionAmount($payment->amount, $partner->commission_percentage);

        $commission = PartnerCommission::create([
            'partner_id' => $partner->id,
            'payment_id' => $payment->id,
            'member_id' => $payment->member_id,
            'commission_percentage' => $partner->commission_percentage,
            'commission_amount' => $commissionAmount,
            'is_paid' => false,
        ]);

        return $commission;
    }

    /**
     * Calculate commission amount based on percentage
     */
    public function calculateCommissionAmount(float $paymentAmount, float $commissionPercentage): float
    {
        return round($paymentAmount * ($commissionPercentage / 100), 2);
    }

    /**
     * Mark commission as paid
     */
    public function markCommissionAsPaid(PartnerCommission $commission): PartnerCommission
    {
        $commission->update([
            'is_paid' => true,
            'paid_at' => now(),
        ]);

        return $commission;
    }

    /**
     * Get partner earnings summary
     */
    public function getPartnerEarningsSummary(Partner $partner): array
    {
        $partner->load(['commissions']);

        $totalEarnings = $partner->getTotalEarnings();
        $paidEarnings = $partner->getTotalPaidEarnings();
        $unpaidEarnings = $partner->getTotalUnpaidEarnings();

        return [
            'total_earnings' => $totalEarnings,
            'paid_earnings' => $paidEarnings,
            'unpaid_earnings' => $unpaidEarnings,
            'total_commissions' => $partner->commissions()->count(),
            'paid_commissions' => $partner->commissions()->where('is_paid', true)->count(),
            'unpaid_commissions' => $partner->commissions()->where('is_paid', false)->count(),
        ];
    }

    /**
     * Get partner commissions with related data
     */
    public function getPartnerCommissionsWithDetails(Partner $partner)
    {
        return $partner->commissions()
            ->with(['payment', 'member'])
            ->orderByDesc('created_at')
            ->paginate(20);
    }

    /**
     * Bulk mark commissions as paid
     */
    public function bulkMarkCommissionsAsPaid(Partner $partner, array $commissionIds = []): int
    {
        $query = $partner->commissions()->where('is_paid', false);

        if (!empty($commissionIds)) {
            $query->whereIn('id', $commissionIds);
        }

        return $query->update([
            'is_paid' => true,
            'paid_at' => now(),
        ]);
    }
}
