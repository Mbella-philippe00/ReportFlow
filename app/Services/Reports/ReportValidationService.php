<?php

namespace App\Services\Reports;

use App\Models\WeeklyReport;
use App\Services\NotificationService;

class ReportValidationService
{
    public function __construct(
        protected NotificationService $notifications,
        protected ReportPresentationService $presentation,
        protected ReportMailService $mail,
        protected ActivityLogService $logs,
    ) {
    }

    /**
     * Pré-validation par un manager.
     */
    public function managerApprove(WeeklyReport $report): void
    {
        $report->update([
            'status' => 'manager_approved',
            'validated_at' => now(),
            'validated_by' => auth()->id(),
        ]);

        $this->notifications->notifySuperAdmins($report);

        $this->mail->sendValidationMail($report);

        $this->logs->log(
            $report,
            'Rapport pré-validé par manager',
            [
                'week' => $report->week,
            ]
        );
    }

    /**
     * Validation finale.
     */
    public function finalApprove(WeeklyReport $report): void
    {
        $pptx = $this->presentation->generatePowerPoint($report);

        $report->update([
            'status' => 'generated',
            'validated_at' => now(),
            'validated_by' => auth()->id(),
            'generated_at' => now(),
            'pptx_file' => $pptx,
        ]);

        $this->notifications->notifyEmployee($report);

        $this->logs->log(
            $report,
            'Rapport validé définitivement',
            [
                'week' => $report->week,
                'pptx_generated' => true,
            ]
        );
    }

    /**
     * Rejet d'un rapport.
     */
    public function reject(
        WeeklyReport $report,
        string $reason
    ): void {
        $report->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejected_by' => auth()->id(),
            'rejection_reason' => $reason,
        ]);

        $this->mail->sendRejectionMail($report);

        $this->logs->log(
            $report,
            'Rapport rejeté',
            [
                'reason' => $reason,
            ]
        );
    }
}