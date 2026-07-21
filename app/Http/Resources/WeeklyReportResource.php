<?php

namespace App\Http\Resources;

use App\Models\WeeklyReport;
use App\Services\Reports\WorkflowStateMachine;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin WeeklyReport
 */
class WeeklyReportResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $stateMachine = app(WorkflowStateMachine::class);
        $user = $request->user();

        return [
            'id' => $this->id,
            'employee' => [
                'id' => $this->employee?->id,
                'name' => $this->employee?->full_name,
                'email' => $this->employee?->email,
            ],
            'department' => $this->department,
            'week' => $this->week,
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
                'color' => $this->status->color(),
            ],
            'objectives' => $this->objectives,
            'activities' => $this->activities,
            'achievements' => $this->achievements,
            'difficulties' => $this->difficulties,
            'next_actions' => $this->next_actions,
            'executive_summary' => $this->executive_summary,
            'pptx_file' => $this->pptx_file,
            'validator' => $this->validator?->name,
            'approver' => $this->approver?->name,
            'rejector' => $this->rejector?->name,
            'manager_comment' => $this->manager_comment,
            'rejection_reason' => $this->rejection_reason,
            'submitted_at' => $this->submitted_at,
            'under_review_at' => $this->under_review_at,
            'validated_at' => $this->validated_at,
            'approved_at' => $this->approved_at,
            'generated_at' => $this->generated_at,
            'rejected_at' => $this->rejected_at,
            'is_read_only' => $this->isReadOnly(),
            'available_actions' => $user ? $this->availableActions($user) : [],
            'workflow' => [
                'next_statuses' => array_map(
                    fn ($status): string => $status->value,
                    $stateMachine->nextStatuses($this->resource),
                ),
                'timeline' => $stateMachine->timeline($this->resource),
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * @return list<string>
     */
    private function availableActions($user): array
    {
        $actions = [];

        foreach (['submit', 'approve', 'finalApprove', 'reject'] as $ability) {
            if ($user->can($ability, $this->resource)) {
                $actions[] = $ability === 'finalApprove' ? 'final-approve' : $ability;
            }
        }

        return $actions;
    }
}
