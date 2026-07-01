<?php

namespace App\Services\Dashboard;

use App\Enums\ReportStatus;
use App\Models\WeeklyReport;

class DashboardService
{
    public function getDashboardData(): array
    {
        $totalReports = WeeklyReport::count();

        $pendingReports = WeeklyReport::where(
            'status',
            ReportStatus::SUBMITTED
        )->count();

        $generatedReports = WeeklyReport::where(
            'status',
            ReportStatus::GENERATED
        )->count();

        $rejectedReports = WeeklyReport::where(
            'status',
            ReportStatus::REJECTED
        )->count();

        $validationRate = $totalReports > 0
            ? round(($generatedReports / $totalReports) * 100, 2)
            : 0;

        return [

            'statistics' => [

                'total_reports' => $totalReports,

                'pending_reports' => $pendingReports,

                'generated_reports' => $generatedReports,

                'rejected_reports' => $rejectedReports,

                'validation_rate' => $validationRate,

            ],

            'recent_reports' => WeeklyReport::latest()
                ->take(10)
                ->get(),

            'pending_reports' => WeeklyReport::where(
                'status',
                ReportStatus::SUBMITTED
            )
                ->latest()
                ->take(10)
                ->get(),

            'charts' => [

                'reports_by_status' => [

                    'draft' => WeeklyReport::where(
                        'status',
                        ReportStatus::DRAFT
                    )->count(),

                    'submitted' => $pendingReports,

                    'generated' => $generatedReports,

                    'rejected' => $rejectedReports,

                ],

            ],

        ];
    }
}
