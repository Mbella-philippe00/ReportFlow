<?php

namespace App\Services\Dashboard;

use App\Enums\ReportStatus;
use App\Models\WeeklyReport;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function getDashboardData(): array
    {
        $summary = $this->dashboardSummary();

        return [
            'statistics' => $summary['statistics'],
            'recent_reports' => WeeklyReport::query()
                ->with(['employee.user', 'validator', 'approver', 'rejector'])
                ->latest()
                ->take(10)
                ->get(),
            'pending_reports' => WeeklyReport::query()
                ->with(['employee.user', 'validator', 'approver', 'rejector'])
                ->whereIn('status', [
                    ReportStatus::SUBMITTED,
                    ReportStatus::UNDER_REVIEW,
                ])
                ->latest()
                ->take(10)
                ->get(),
            'charts' => $summary['charts'],
        ];
    }

    /**
     * @return array{statistics: array<string, mixed>, charts: array<string, mixed>}
     */
    private function dashboardSummary(): array
    {
        if (app()->environment('testing')) {
            return $this->buildDashboardSummary();
        }

        return Cache::remember(
            'reportflow.dashboard.summary.v1',
            now()->addSeconds((int) config('reportflow.cache.dashboard_ttl', 60)),
            fn (): array => $this->buildDashboardSummary(),
        );
    }

    /**
     * @return array{statistics: array<string, mixed>, charts: array<string, mixed>}
     */
    private function buildDashboardSummary(): array
    {
        $statusCounts = WeeklyReport::query()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $draftReports = $this->countStatus($statusCounts, ReportStatus::DRAFT);
        $submittedReports = $this->countStatus($statusCounts, ReportStatus::SUBMITTED);
        $underReviewReports = $this->countStatus($statusCounts, ReportStatus::UNDER_REVIEW);
        $approvedReports = $this->countStatus($statusCounts, ReportStatus::APPROVED);
        $rejectedReports = $this->countStatus($statusCounts, ReportStatus::REJECTED);
        $totalReports = $statusCounts->sum();
        $pendingReports = $submittedReports + $underReviewReports;
        $decidedReports = $approvedReports + $rejectedReports;

        $validationRate = $decidedReports > 0
            ? round(($approvedReports / $decidedReports) * 100, 2)
            : 0;

        return [
            'statistics' => [
                'total_reports' => $totalReports,
                'draft_reports' => $draftReports,
                'submitted_reports' => $submittedReports,
                'under_review_reports' => $underReviewReports,
                'pending_reports' => $pendingReports,
                'approved_reports' => $approvedReports,
                'generated_reports' => $approvedReports,
                'rejected_reports' => $rejectedReports,
                'validation_rate' => $validationRate,
                'workflow_kpis' => [
                    'manager_queue' => $submittedReports,
                    'final_approval_queue' => $underReviewReports,
                    'approved_reports' => $approvedReports,
                    'rejected_reports' => $rejectedReports,
                    'read_only_reports' => $approvedReports,
                ],
            ],
            'charts' => [
                'reports_by_status' => [
                    'draft' => $draftReports,
                    'submitted' => $submittedReports,
                    'under_review' => $underReviewReports,
                    'approved' => $approvedReports,
                    'rejected' => $rejectedReports,
                ],
            ],
        ];
    }

    private function countStatus($statusCounts, ReportStatus $status): int
    {
        return (int) ($statusCounts[$status->value] ?? 0);
    }
}
