<?php

namespace App\Services\Reports;

use App\Models\WeeklyReport;
use App\Services\AI\WeeklyReportAiService;
use App\Services\NotificationService;

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
        // Mise à jour du statut
        $report->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        // Génération IA si nécessaire
        if (blank($report->executive_summary)) {
            $summary = $this->ai->generateExecutiveSummary($report);

            $report->update([
                'executive_summary' => $summary,
            ]);
        }

        // Notification des managers
        $this->notifications->notifyManagers($report);

        // Journalisation
        activity()
            ->performedOn($report)
            ->causedBy(auth()->user())
            ->withProperties([
                'week' => $report->week,
            ])
            ->log('Rapport soumis');
    }
}