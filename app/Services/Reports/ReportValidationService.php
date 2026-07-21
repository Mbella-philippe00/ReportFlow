<?php

namespace App\Services\Reports;

use App\Enums\ReportStatus;
use App\Models\WeeklyReport;
use App\Services\NotificationService;

class ReportValidationService
{
    public function __construct(
        protected NotificationService $notifications,
        protected ReportPresentationService $presentation,
        protected ReportMailService $mail,
        protected ActivityLogService $logs,
        protected WorkflowStateMachine $stateMachine,
    ) {}

    public function managerApprove(WeeklyReport $report, ?string $comment = null): void
    {
        $this->stateMachine->assertCanTransition($report, ReportStatus::UNDER_REVIEW);

        $report->update([
            'status' => ReportStatus::UNDER_REVIEW,
            'under_review_at' => now(),
            'validated_at' => now(),
            'validated_by' => auth()->id(),
            'manager_comment' => $comment,
        ]);

        $this->notifications->notifySuperAdmins($report->fresh());

        $this->logs->log(
            $report->fresh(),
            'Report moved under review',
            [
                'event' => 'under_review',
                'to' => ReportStatus::UNDER_REVIEW->value,
                'week' => $report->week,
                'comment' => $comment,
            ],
        );
    }

    public function finalApprove(WeeklyReport $report): void
    {
        $this->stateMachine->assertCanTransition($report, ReportStatus::APPROVED);

        $pptx = $this->presentation->generatePowerPoint($report);
        $approvedAt = now();

        $report->update([
            'status' => ReportStatus::APPROVED,
            'approved_at' => $approvedAt,
            'approved_by' => auth()->id(),
            'generated_at' => $approvedAt,
            'pptx_file' => $pptx,
        ]);

        $this->notifications->notifyEmployee($report->fresh());
        $this->mail->sendValidationMail($report->fresh());

        $this->logs->log(
            $report->fresh(),
            'Report approved',
            [
                'event' => 'approved',
                'to' => ReportStatus::APPROVED->value,
                'week' => $report->week,
                'pptx_generated' => true,
            ],
        );
    }

    public function reject(WeeklyReport $report, string $reason): void
    {
        $this->stateMachine->assertCanTransition($report, ReportStatus::REJECTED);

        $report->update([
            'status' => ReportStatus::REJECTED,
            'rejected_at' => now(),
            'rejected_by' => auth()->id(),
            'rejection_reason' => $reason,
        ]);

        $this->notifications->notifyEmployeeRejected($report->fresh());
        $this->mail->sendRejectionMail($report->fresh());

        $this->logs->log(
            $report->fresh(),
            'Report rejected',
            [
                'event' => 'rejected',
                'to' => ReportStatus::REJECTED->value,
                'week' => $report->week,
                'reason' => $reason,
            ],
        );
    }
}
