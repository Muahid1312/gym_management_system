<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Payment;
use App\Models\Expense;
use Carbon\Carbon;

class FinancialReportService
{
    /**
     * Get daily income for a specific date.
     */
    public function getDailyIncome(string $date): float
    {
        return Payment::whereDate('paid_at', $date)->sum('amount');
    }

    /**
     * Get today's income.
     */
    public function getTodayIncome(): float
    {
        return $this->getDailyIncome(now()->toDateString());
    }

    /**
     * Get monthly income for a specific year and month.
     */
    public function getMonthlyIncome(int $year, int $month): float
    {
        return Payment::whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->sum('amount');
    }

    /**
     * Get current month income.
     */
    public function getCurrentMonthIncome(): float
    {
        return $this->getMonthlyIncome(now()->year, now()->month);
    }

    /**
     * Get total outstanding debt from all members.
     */
    public function getTotalOutstandingDebt(): float
    {
        return Member::sum('debt');
    }

    /**
     * Get yearly income for a specific year.
     */
    public function getYearlyIncome(int $year): float
    {
        return Payment::whereYear('paid_at', $year)->sum('amount');
    }

    /**
     * Get income statistics for the current month (day by day).
     */
    public function getMonthlyIncomeByDay(int $year = null, int $month = null): array
    {
        $year = $year ?? now()->year;
        $month = $month ?? now()->month;

        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        $income = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateString = Carbon::createFromDate($year, $month, $day)->toDateString();
            $income[$dateString] = $this->getDailyIncome($dateString);
        }

        return $income;
    }

    /**
     * Get total income by plan (which plans generate the most revenue).
     */
    public function getIncomeByPlan(): array
    {
        return Payment::with('plan')
            ->get()
            ->groupBy('plan_id')
            ->map(function ($payments, $planId) {
                $plan = $payments->first()->plan;

                return [
                    'plan_id' => $planId,
                    'plan_name' => $plan->name ?? 'Unknown',
                    'total_income' => $payments->sum('amount'),
                    'payment_count' => $payments->count(),
                    'average_payment' => $payments->avg('amount'),
                ];
            })
            ->values()
            ->toArray();
    }

    /**
     * Get debt statistics.
     */
    public function getDebtStatistics(): array
    {
        $membersWithDebt = Member::where('debt', '>', 0)->get();

        return [
            'total_debt' => $this->getTotalOutstandingDebt(),
            'members_with_debt' => $membersWithDebt->count(),
            'average_debt_per_member' => $membersWithDebt->count() > 0 ? $membersWithDebt->average('debt') : 0,
            'highest_debt' => $membersWithDebt->max('debt') ?? 0,
        ];
    }

    /**
     * Get income comparison between two months.
     */
    public function compareMonths(int $year1, int $month1, int $year2, int $month2): array
    {
        $income1 = $this->getMonthlyIncome($year1, $month1);
        $income2 = $this->getMonthlyIncome($year2, $month2);

        $difference = $income2 - $income1;
        $percentageChange = $income1 > 0 ? ($difference / $income1) * 100 : 0;

        return [
            'month1_income' => $income1,
            'month2_income' => $income2,
            'difference' => $difference,
            'percentage_change' => $percentageChange,
            'trend' => $difference > 0 ? 'up' : ($difference < 0 ? 'down' : 'stable'),
        ];
    }

    /**
     * Get payment statistics for a member.
     */
    public function getMemberPaymentStats(int $memberId): array
    {
        $payments = Payment::where('member_id', $memberId)->get();

        return [
            'total_paid' => $payments->sum('amount'),
            'payment_count' => $payments->count(),
            'average_payment' => $payments->count() > 0 ? $payments->avg('amount') : 0,
            'last_payment_date' => $payments->max('paid_at'),
            'first_payment_date' => $payments->min('paid_at'),
        ];
    }

    /**
     * Get daily expenses for a specific date.
     */
    public function getDailyExpenses(string $date): float
    {
        return Expense::whereDate('date', $date)->sum('amount');
    }

    /**
     * Get today's expenses.
     */
    public function getTodayExpenses(): float
    {
        return $this->getDailyExpenses(now()->toDateString());
    }

    /**
     * Get monthly expenses for a specific year and month.
     */
    public function getMonthlyExpenses(int $year, int $month): float
    {
        return Expense::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');
    }

    /**
     * Get current month expenses.
     */
    public function getCurrentMonthExpenses(): float
    {
        return $this->getMonthlyExpenses(now()->year, now()->month);
    }

    /**
     * Get total profit (income - expenses) for current month.
     */
    public function getCurrentMonthProfit(): float
    {
        return $this->getCurrentMonthIncome() - $this->getCurrentMonthExpenses();
    }

    /**
     * Get total profit (income - expenses) for today.
     */
    public function getTodayProfit(): float
    {
        return $this->getTodayIncome() - $this->getTodayExpenses();
    }
}
