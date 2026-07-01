<?php

namespace App\Services\Reports;

use App\Enums\ReportStatus;
use App\Models\WeeklyReport;
use App\Services\NotificationService;
use Illuminate\Validation\ValidationException;

class ReportValidationService
{
    public function __construct(
        protected NotificationService $notifications,
        protected ReportPresentationService $presentation,
        protected ReportMailService $mail,
        protected ActivityLogService $logs,
    ) {}

    /**
     * Pré-validation par un manager.
     */
    public function managerApprove(WeeklyReport $report): void
    {
        if (! $report->isSubmitted()) {
            throw ValidationException::withMessages([
                'status' => [
                    'Only submitted reports can be approved.',
                ],
            ]);
        }

        $report->update([
            'status' => ReportStatus::MANAGER_APPROVED,
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
        if (! $report->isManagerApproved()) {
            throw ValidationException::withMessages([
                'status' => [
                    'Only manager approved reports can be finally approved.',
                ],
            ]);
        }

        $pptx = $this->presentation->generatePowerPoint($report);

        $report->update([
            'status' => ReportStatus::GENERATED,
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

        if (
            ! $report->isSubmitted()
            && ! $report->isManagerApproved()
        ) {
            throw ValidationException::withMessages([
                'status' => [
                    'Only submitted or manager approved reports can be rejected.',
                ],
            ]);
        }

        $report->update([
            'status' => ReportStatus::REJECTED,
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
