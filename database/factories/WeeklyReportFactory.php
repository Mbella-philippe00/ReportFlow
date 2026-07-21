<?php

namespace Database\Factories;

use App\Enums\ReportStatus;
use App\Models\Employee;
use App\Models\User;
use App\Models\WeeklyReport;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WeeklyReport>
 */
class WeeklyReportFactory extends Factory
{
    protected $model = WeeklyReport::class;

    public function definition(): array
    {
        $project = fake()->randomElement([
            'customer onboarding',
            'monthly close',
            'quality review',
            'internal tooling',
            'delivery planning',
            'support backlog',
            'sales pipeline',
            'product discovery',
        ]);

        return [
            'employee_id' => Employee::factory(),
            'department' => fake()->randomElement(EmployeeFactory::DEPARTMENTS),
            'week' => now()->format('o-\WW'),
            'objectives' => "Advance {$project} priorities, unblock cross-team decisions, and document measurable outcomes.",
            'activities' => fake()->randomElement([
                'Coordinated stakeholder reviews, updated the delivery board, and resolved follow-up actions from the previous sprint.',
                'Reviewed operational metrics, prepared status notes, and paired with teammates on high-priority requests.',
                'Validated open tasks, refined documentation, and supported daily execution across planned workstreams.',
                'Analyzed incoming feedback, triaged risks, and aligned next steps with the team lead.',
            ]),
            'achievements' => fake()->randomElement([
                'Completed the planned milestones and reduced the number of open blockers before the weekly checkpoint.',
                'Delivered the main work package on schedule and improved handoff notes for the next owner.',
                'Closed priority actions while keeping quality indicators within the expected range.',
                'Resolved a critical dependency and kept the team on track for the monthly target.',
            ]),
            'difficulties' => fake()->randomElement([
                'Waiting on external validation for one dependency.',
                'A late requirement change required additional coordination.',
                'Competing priorities reduced focus time for documentation.',
                'No major difficulty reported this week.',
            ]),
            'next_actions' => fake()->randomElement([
                'Finalize the remaining validation points and prepare the next status review.',
                'Share the updated action plan, confirm ownership, and monitor delivery risks.',
                'Complete documentation updates and start the next improvement cycle.',
                'Review the metrics with the manager and prioritize follow-up work.',
            ]),
            'executive_summary' => fake()->randomElement([
                'Progress is on track with minor coordination risks to monitor next week.',
                'The team completed the main deliverables and is ready for the next review cycle.',
                'Execution remains stable, with attention needed on dependencies and follow-up actions.',
                'The week ended positively with measurable progress against planned objectives.',
            ]),
            'status' => ReportStatus::DRAFT,
        ];
    }

    public function draft(): static
    {
        return $this->state($this->blankWorkflowState(ReportStatus::DRAFT));
    }

    public function submitted(?CarbonInterface $submittedAt = null): static
    {
        $submittedAt ??= now();

        return $this->state([
            ...$this->blankWorkflowState(ReportStatus::SUBMITTED),
            'submitted_at' => $submittedAt,
        ]);
    }

    public function underReview(?User $manager = null, ?CarbonInterface $reviewedAt = null): static
    {
        $reviewedAt ??= now();

        return $this->state([
            ...$this->blankWorkflowState(ReportStatus::UNDER_REVIEW),
            'submitted_at' => $reviewedAt->copy()->subDay(),
            'under_review_at' => $reviewedAt,
            'validated_at' => $reviewedAt,
            'validated_by' => $manager?->id,
            'manager_comment' => 'Looks ready for final approval. Please verify the generated deck.',
        ]);
    }

    public function approved(?User $approver = null, ?CarbonInterface $approvedAt = null): static
    {
        $approvedAt ??= now();
        $reviewedAt = $approvedAt->copy()->subDay();

        return $this->state([
            ...$this->blankWorkflowState(ReportStatus::APPROVED),
            'submitted_at' => $approvedAt->copy()->subDays(2),
            'under_review_at' => $reviewedAt,
            'validated_at' => $reviewedAt,
            'validated_by' => $approver?->id,
            'approved_at' => $approvedAt,
            'approved_by' => $approver?->id,
            'manager_comment' => 'Approved at manager review with no blocking risks.',
            'generated_at' => $approvedAt,
            'pptx_file' => 'reports/demo-'.$approvedAt->format('YmdHis').'.pptx',
        ]);
    }

    public function rejected(?User $rejector = null, ?CarbonInterface $rejectedAt = null): static
    {
        $rejectedAt ??= now();

        return $this->state([
            ...$this->blankWorkflowState(ReportStatus::REJECTED),
            'submitted_at' => $rejectedAt->copy()->subDay(),
            'rejected_at' => $rejectedAt,
            'rejected_by' => $rejector?->id,
            'rejection_reason' => fake()->randomElement([
                'Please add measurable outcomes before resubmitting.',
                'The blockers need clearer ownership and follow-up dates.',
                'Some activities are missing supporting details.',
                'The next actions need to be aligned with department priorities.',
            ]),
        ]);
    }

    public function managerApproved(?User $manager = null, ?CarbonInterface $validatedAt = null): static
    {
        return $this->underReview($manager, $validatedAt);
    }

    public function generated(?User $approver = null, ?CarbonInterface $generatedAt = null): static
    {
        return $this->approved($approver, $generatedAt);
    }

    public function withoutSummary(): static
    {
        return $this->state([
            'executive_summary' => null,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function blankWorkflowState(ReportStatus $status): array
    {
        return [
            'status' => $status,
            'submitted_at' => null,
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
        ];
    }
}
