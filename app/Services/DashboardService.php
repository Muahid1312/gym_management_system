<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Payment;

class DashboardService
{
    public function __construct(
        private RiskDetectionService $riskService,
        private FinancialReportService $financialService
    ) {}

    /**
     * Get all dashboard metrics in one consolidated call.
     */
    public function getDashboardMetrics(): array
    {
        return [
            'members' => $this->getMemberMetrics(),
            'financial' => $this->getFinancialMetrics(),
            'risks' => $this->riskService->getRiskSummary(),
            'alerts' => $this->getAlerts(),
        ];
    }

    /**
     * Get member-related metrics.
     */
    public function getMemberMetrics(): array
    {
        return [
            'total_members' => Member::count(),
            'active_members' => Member::where('expiry_date', '>=', now()->toDateString())->count(),
            'expired_members' => Member::where('expiry_date', '<', now()->toDateString())->count(),
            'members_expiring_soon' => collect($this->riskService->getMembersExpiringsoon())->count(),
            'members_with_debt' => collect($this->riskService->getMembersWithDebt())->count(),
        ];
    }

    /**
     * Get financial-related metrics.
     */
    public function getFinancialMetrics(): array
    {
        return [
            'today_income' => $this->financialService->getTodayIncome(),
            'monthly_income' => $this->financialService->getCurrentMonthIncome(),
            'today_expenses' => $this->financialService->getTodayExpenses(),
            'monthly_expenses' => $this->financialService->getCurrentMonthExpenses(),
            'today_profit' => $this->financialService->getTodayProfit(),
            'monthly_profit' => $this->financialService->getCurrentMonthProfit(),
            'total_outstanding_debt' => $this->financialService->getTotalOutstandingDebt(),
            'debt_stats' => $this->financialService->getDebtStatistics(),
        ];
    }

    /**
     * Get alerts for display in the dashboard.
     */
    public function getAlerts(): array
    {
        $alerts = [];

        // Expiring soon alert
        $expiringSoonCount = $this->getMemberMetrics()['members_expiring_soon'];
        if ($expiringSoonCount > 0) {
            $alerts[] = [
                'type' => 'warning',
                'title' => 'اعضای در حال انقضا',
                'message' => "{$expiringSoonCount} عضو ظرف ۳ روز آینده منقضی می‌شوند",
                'count' => $expiringSoonCount,
                'action_url' => route('members.index', ['filter' => 'expiring_soon']),
            ];
        }

        // Debt alert
        $debtCount = $this->getMemberMetrics()['members_with_debt'];
        if ($debtCount > 0) {
            $totalDebt = $this->getFinancialMetrics()['total_outstanding_debt'];
            $alerts[] = [
                'type' => 'danger',
                'title' => 'بدهی‌های معوق',
                'message' => "{$debtCount} عضو بدهی معادل " . number_format($totalDebt, 2) . " افغانی دارند",
                'count' => $debtCount,
                'action_url' => route('members.index', ['filter' => 'in_debt']),
            ];
        }

        // Inactive members alert
        $inactiveCount = collect($this->riskService->getMembersInactive())->count();
        if ($inactiveCount > 0) {
            $alerts[] = [
                'type' => 'info',
                'title' => 'اعضای غیرفعال',
                'message' => "{$inactiveCount} عضو اخیراً حضور نداشته‌اند",
                'count' => $inactiveCount,
                'action_url' => route('members.index', ['filter' => 'inactive']),
            ];
        }

        return $alerts;
    }

    /**
     * Get quick stats for dashboard cards.
     */
    public function getQuickStats(): array
    {
        $financial = $this->getFinancialMetrics();
        
        return [
            [
                'label' => 'اعضای فعال',
                'value' => $this->getMemberMetrics()['active_members'],
                'icon' => '👥',
                'color' => 'bg-blue-500',
            ],
            [
                'label' => 'اعضای منقضی شده',
                'value' => $this->getMemberMetrics()['expired_members'],
                'icon' => '⏰',
                'color' => 'bg-red-500',
            ],
            [
                'label' => 'درآمد امروز',
                'value' => number_format($financial['today_income'], 2) . ' افغانی',
                'icon' => '💰',
                'color' => 'bg-green-500',
            ],
            [
                'label' => 'مصارف امروز',
                'value' => number_format($financial['today_expenses'], 2) . ' افغانی',
                'icon' => '💸',
                'color' => 'bg-red-500',
            ],
            [
                'label' => 'سود امروز',
                'value' => number_format($financial['today_profit'], 2) . ' افغانی',
                'icon' => $financial['today_profit'] >= 0 ? '📈' : '📉',
                'color' => $financial['today_profit'] >= 0 ? 'bg-green-500' : 'bg-red-500',
            ],
            [
                'label' => 'بدهی معوق',
                'value' => number_format($financial['total_outstanding_debt'], 2) . ' افغانی',
                'icon' => '💳',
                'color' => 'bg-yellow-500',
            ],
        ];
    }
}
