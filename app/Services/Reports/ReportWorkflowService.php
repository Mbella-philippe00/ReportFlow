<?php

namespace App\Services\Reports;

use App\Enums\ReportStatus;
use App\Models\WeeklyReport;
use App\Services\AI\WeeklyReportAiService;
use App\Services\NotificationService;
use Illuminate\Validation\ValidationException;

class ReportWorkflowService
{
    public function __construct(
        protected WeeklyReportAiService $ai,
        protected NotificationService $notifications,
    ) {}

    /**
     * Soumission d'un rapport par un employé.
     */
    public function submit(WeeklyReport $report): void
    {
        if (! $report->isDraft()) {
            throw ValidationException::withMessages([
                'status' => [
                    'Only draft reports can be submitted.',
                ],
            ]);
        }

        $report->update([
            'status' => ReportStatus::SUBMITTED,
            'submitted_at' => now(),
        ]);

        if (blank($report->executive_summary)) {
            $report->update([
                'executive_summary' => $this->ai->generateExecutiveSummary($report),
            ]);
        }

        $this->notifications->notifyManagers($report);

        activity()
            ->performedOn($report)
            ->causedBy(auth()->user())
            ->withProperties([
                'week' => $report->week,
            ])
            ->log('Rapport soumis');
    }
}
