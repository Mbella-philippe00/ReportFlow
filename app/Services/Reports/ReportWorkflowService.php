<?php

namespace App\Services\Reports;

use App\Enums\ReportStatus;
use App\Models\User;
use App\Models\WeeklyReport;
use App\Services\AI\WeeklyReportAiService;
use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ReportWorkflowService
{
    public function __construct(
        protected WeeklyReportAiService $ai,
        protected NotificationService $notifications,
        protected WorkflowStateMachine $stateMachine,
        protected ActivityLogService $logs,
    ) {}

    public function submit(WeeklyReport $report): void
    {
        $this->stateMachine->assertCanTransition($report, ReportStatus::SUBMITTED);

        $report->update([
            'status' => ReportStatus::SUBMITTED,
            'submitted_at' => now(),
            'under_review_at' => null,
            'validated_at' => null,
            'validated_by' => null,
            'approved_at' => null,
            'approved_by' => null,
            'manager_comment' => null,
            'rejected_at' => null,
            'rejected_by' => null,
            'rejection_reason' => null,
            'generated_at' => null,
            'pptx_file' => null,
        ]);

        if (blank($report->executive_summary)) {
            $report->update([
                'executive_summary' => $this->ai->generateExecutiveSummary($report->fresh()),
            ]);
        }

        $this->notifications->notifyManagers($report->fresh());

        $this->logs->log(
            $report->fresh(),
            'Report submitted',
            [
                'event' => 'submitted',
                'from' => $report->getOriginal('status') instanceof ReportStatus
                    ? $report->getOriginal('status')->value
                    : (string) $report->getOriginal('status'),
                'to' => ReportStatus::SUBMITTED->value,
                'week' => $report->week,
            ],
        );
    }

    /**
     * @return Collection<int, WeeklyReport>
     */
    public function queueFor(User $user): Collection
    {
        return WeeklyReport::query()
            ->with(['employee.user', 'validator', 'approver', 'rejector'])
            ->where(function (Builder $query) use ($user): void {
                if ($user->hasRole('super-admin')) {
                    $query->whereIn('status', [
                        ReportStatus::SUBMITTED->value,
                        ReportStatus::UNDER_REVIEW->value,
                    ]);

                    return;
                }

                if ($user->hasRole('manager')) {
                    $query->where('status', ReportStatus::SUBMITTED->value);

                    return;
                }

                $query->where('employee_id', $user->employee?->id)
                    ->whereIn('status', [
                        ReportStatus::DRAFT->value,
                        ReportStatus::REJECTED->value,
                    ]);
            })
            ->latest('updated_at')
            ->take(50)
            ->get();
    }
}
