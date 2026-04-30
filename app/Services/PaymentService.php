<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Payment;
use App\Models\Plan;

class PaymentService
{
    public function processPayment(Member $member, Plan $plan, float $amount, bool $isPartial = false): void
    {
        Payment::create([
            'member_id' => $member->id,
            'plan_id' => $plan->id,
            'amount' => $amount,
            'paid_at' => now(),
            'is_partial' => $isPartial,
        ]);

        $member->debt -= $amount;
        if ($member->debt < 0) {
            $member->debt = 0;
        }

        if (!$isPartial || $member->debt == 0) {
            $member->extendExpiry($plan);
        }

        $member->save();
    }

    public function calculateDebt(Member $member, Plan $plan): float
    {
        return max(0, $plan->price - $member->payments()->sum('amount'));
    }
}
