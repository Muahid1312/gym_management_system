<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Payment;
use App\Models\Plan;

class PaymentService
{
    public function __construct(
        protected ReceiptService $receiptService,
        protected PartnerService $partnerService,
    ) {
    }

    public function processPayment(
        Member $member,
        Plan $plan,
        float $amount,
        bool $isPartial = false,
        ?int $partnerId = null,
        string $paymentMethod = 'cash',
        ?string $notes = null
    ): Payment {
        // Ensure amount is properly formatted to 2 decimal places
        $amount = (float) number_format($amount, 2, '.', '');

        $payment = Payment::create([
            'member_id' => $member->id,
            'plan_id' => $plan->id,
            'amount' => $amount,
            'paid_at' => now(),
            'is_partial' => $isPartial,
            'partner_id' => $partnerId,
            'payment_method' => $paymentMethod,
            'notes' => $notes,
        ]);

        // Update member debt with proper decimal precision
        $newDebt = (float) number_format((float) $member->debt - $amount, 2, '.', '');
        $member->debt = max(0, $newDebt);

        if (!$isPartial || $member->debt == 0) {
            $member->extendExpiry($plan);
        }

        $member->save();

        // Generate receipt
        $this->receiptService->createReceipt($payment, $paymentMethod, $notes);

        // Calculate and create commission if partner is linked
        $this->partnerService->calculateAndCreateCommission($payment);

        return $payment->load('receipt');
    }

    public function calculateDebt(Member $member, Plan $plan): float
    {
        return max(0, $plan->price - $member->payments()->sum('amount'));
    }
}

