<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getDailyIncome(string $date): float
    {
        return Payment::whereDate('paid_at', $date)->sum('amount');
    }

    public function getMonthlyIncome(int $year, int $month): float
    {
        return Payment::whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->sum('amount');
    }

    public function getActiveMembersCount(): int
    {
        return Member::where('expiry_date', '>=', now()->toDateString())->count();
    }

    public function getExpiredMembersCount(): int
    {
        return Member::where('expiry_date', '<', now()->toDateString())->count();
    }

    public function getMembersWithDebt(): array
    {
        return Member::where('debt', '>', 0)->with('plan')->get()->toArray();
    }
}
