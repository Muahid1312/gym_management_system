<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function __construct(protected ReportService $reportService)
    {
    }

    public function index()
    {
        $data = [
            'dailyIncome' => $this->reportService->getDailyIncome(now()->toDateString()),
            'monthlyIncome' => $this->reportService->getMonthlyIncome(now()->year, now()->month),
            'activeMembers' => $this->reportService->getActiveMembersCount(),
            'expiredMembers' => $this->reportService->getExpiredMembersCount(),
            'membersWithDebt' => $this->reportService->getMembersWithDebt(),
        ];

        return view('reports.index', $data);
    }

    public function exportPdf()
    {
        $data = [
            'dailyIncome' => $this->reportService->getDailyIncome(now()->toDateString()),
            'monthlyIncome' => $this->reportService->getMonthlyIncome(now()->year, now()->month),
            'activeMembers' => $this->reportService->getActiveMembersCount(),
            'expiredMembers' => $this->reportService->getExpiredMembersCount(),
            'membersWithDebt' => $this->reportService->getMembersWithDebt(),
        ];

        $pdf = Pdf::loadView('reports.pdf', $data);

        return $pdf->download('gym_report.pdf');
    }
}
