<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\RiskDetectionService;
use App\Services\FinancialReportService;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
        private RiskDetectionService $riskService,
        private FinancialReportService $financialService
    ) {}

    public function index()
    {
        $metrics = $this->dashboardService->getDashboardMetrics();
        $quickStats = $this->dashboardService->getQuickStats();
        $alerts = $this->dashboardService->getAlerts();

        return view('dashboard-modern', [
            'metrics' => $metrics,
            'quickStats' => $quickStats,
            'alerts' => $alerts,
            'expiringSoon' => $this->riskService->getMembersExpiringsoon(),
            'withDebt' => $this->riskService->getMembersWithDebt(),
            'inactive' => $this->riskService->getMembersInactive(),
            'monthlyIncomeByDay' => $this->financialService->getMonthlyIncomeByDay(),
            'incomeByPlan' => $this->financialService->getIncomeByPlan(),
        ]);
    }
}
