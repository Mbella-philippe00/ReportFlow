<?php

namespace App\Services\Reports;

use App\Enums\ReportStatus;
use App\Models\WeeklyReport;
use Illuminate\Validation\ValidationException;

class WorkflowStateMachine
{
    /**
     * @return array<string, list<ReportStatus>>
     */
    public function transitions(): array
    {
        return [
            ReportStatus::DRAFT->value => [ReportStatus::SUBMITTED],
            ReportStatus::SUBMITTED->value => [ReportStatus::UNDER_REVIEW, ReportStatus::REJECTED],
            ReportStatus::UNDER_REVIEW->value => [ReportStatus::APPROVED, ReportStatus::REJECTED],
            ReportStatus::APPROVED->value => [],
            ReportStatus::REJECTED->value => [ReportStatus::SUBMITTED],
        ];
    }

    /**
     * @return list<ReportStatus>
     */
    public function nextStatuses(WeeklyReport $report): array
    {
        return $this->transitions()[$report->status->value] ?? [];
    }

    public function canTransition(WeeklyReport $report, ReportStatus $target): bool
    {
        return in_array($target, $this->nextStatuses($report), true);
    }

    public function assertCanTransition(WeeklyReport $report, ReportStatus $target): void
    {
        if ($this->canTransition($report, $target)) {
            return;
        }

        throw ValidationException::withMessages([
            'status' => [sprintf(
                'Cannot transition report from %s to %s.',
                $report->status->label(),
                $target->label(),
            )],
        ]);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function timeline(WeeklyReport $report): array
    {
        $events = [
            [
                'key' => 'draft',
                'label' => 'Draft',
                'status' => $report->status === ReportStatus::DRAFT ? 'current' : 'completed',
                'actor' => $report->employee?->full_name,
                'comment' => 'Report created as a draft.',
                'occurred_at' => $report->created_at,
            ],
        ];

        if ($report->submitted_at !== null) {
            $events[] = [
                'key' => 'submitted',
                'label' => 'Submitted',
                'status' => $report->status === ReportStatus::SUBMITTED ? 'current' : 'completed',
                'actor' => $report->employee?->full_name,
                'comment' => 'Report submitted for manager review.',
                'occurred_at' => $report->submitted_at,
            ];
        }

        if ($report->under_review_at !== null || $report->validated_at !== null) {
            $events[] = [
                'key' => 'under_review',
                'label' => 'Under Review',
                'status' => $report->status === ReportStatus::UNDER_REVIEW ? 'current' : 'completed',
                'actor' => $report->validator?->name,
                'comment' => $report->manager_comment ?: 'Manager review completed.',
                'occurred_at' => $report->under_review_at ?? $report->validated_at,
            ];
        }

        if ($report->approved_at !== null || $report->generated_at !== null) {
            $events[] = [
                'key' => 'approved',
                'label' => 'Approved',
                'status' => 'completed',
                'actor' => $report->approver?->name ?? $report->validator?->name,
                'comment' => $report->pptx_file ? 'Report approved and PowerPoint generated.' : 'Report approved.',
                'occurred_at' => $report->approved_at ?? $report->generated_at,
            ];
        }

        if ($report->rejected_at !== null) {
            $events[] = [
                'key' => 'rejected',
                'label' => 'Rejected',
                'status' => 'rejected',
                'actor' => $report->rejector?->name,
                'comment' => $report->rejection_reason,
                'occurred_at' => $report->rejected_at,
            ];
        }

        return $events;
    }
}
