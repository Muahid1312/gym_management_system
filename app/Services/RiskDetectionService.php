<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Setting;
use Carbon\Carbon;

class RiskDetectionService
{
    /**
     * Get members whose expiry date is within the configured reminder days.
     */
    public function getMembersExpiringsoon(): array
    {
        $reminderDays = Setting::get('expiry_reminder_days', 3);
        $expiryDate = now()->addDays($reminderDays)->toDateString();

        return Member::whereBetween('expiry_date', [
            now()->toDateString(),
            $expiryDate,
        ])
            ->with(['plan', 'payments'])
            ->orderBy('expiry_date', 'asc')
            ->get()
            ->toArray();
    }

    /**
     * Get members with unpaid balance (debt > 0).
     */
    public function getMembersWithDebt(): array
    {
        return Member::where('debt', '>', 0)
            ->with(['plan', 'payments'])
            ->orderBy('debt', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get members inactive for several days based on attendance records.
     */
    public function getMembersInactive(): array
    {
        $inactivityDays = Setting::get('inactivity_days', 7);
        $inactivityThreshold = now()->subDays($inactivityDays)->toDateString();

        return Member::where('expiry_date', '>=', now()->toDateString())
            ->where(function ($query) use ($inactivityThreshold) {
                $query->has('attendances', '<', 1)
                    ->orWhereHas('attendances', function ($q) use ($inactivityThreshold) {
                        $q->whereDate('check_in_time', '<', $inactivityThreshold);
                    }, '=', 0);
            })
            ->with(['plan', 'attendances' => function ($query) {
                $query->latest('check_in_time')->first();
            }])
            ->get()
            ->toArray();
    }

    /**
     * Get count summaries for dashboard alerts.
     */
    public function getRiskSummary(): array
    {
        return [
            'expiring_soon_count' => collect($this->getMembersExpiringsoon())->count(),
            'with_debt_count' => collect($this->getMembersWithDebt())->count(),
            'inactive_count' => collect($this->getMembersInactive())->count(),
        ];
    }

    /**
     * Get all at-risk members in one call.
     */
    public function getAllAtRiskMembers(): array
    {
        return [
            'expiring_soon' => $this->getMembersExpiringsoon(),
            'with_debt' => $this->getMembersWithDebt(),
            'inactive' => $this->getMembersInactive(),
        ];
    }

    /**
     * Get days until expiry for a specific member.
     */
    public function getDaysUntilExpiry(Member $member): ?int
    {
        if (!$member->expiry_date) {
            return null;
        }

        return now()->diffInDays($member->expiry_date, false);
    }

    /**
     * Check if a member is at risk.
     */
    public function isAtRisk(Member $member): bool
    {
        $reminderDays = Setting::get('expiry_reminder_days', 3);

        $expiringsSoon = $member->expiry_date && $member->expiry_date->lessThanOrEqualTo(now()->addDays($reminderDays));
        $hasDebt = $member->debt > 0;
        $isInactive = $this->isInactive($member);

        return $expiringsSoon || $hasDebt || $isInactive;
    }

    /**
     * Check if a member is inactive.
     */
    public function isInactive(Member $member): bool
    {
        $inactivityDays = Setting::get('inactivity_days', 7);
        $lastAttendance = $member->attendances()->latest('check_in_time')->first();

        if (!$lastAttendance) {
            return true;
        }

        return $lastAttendance->check_in_time->lessThan(now()->subDays($inactivityDays));
    }
}
