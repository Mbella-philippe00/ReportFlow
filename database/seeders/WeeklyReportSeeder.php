<?php

namespace Database\Seeders;

use App\Enums\ReportStatus;
use App\Models\Employee;
use App\Models\User;
use App\Models\WeeklyReport;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class WeeklyReportSeeder extends Seeder
{
    private const TARGET_REPORTS = 121;

    public function run(): void
    {
        $employees = Employee::query()->with('user')->get();
        $managers = User::role('manager')->get();
        $superAdmin = User::role('super-admin')->firstOrFail();

        if ($employees->isEmpty() || $managers->isEmpty()) {
            return;
        }

        $statusPlan = $this->statusPlan();
        $combinations = $this->reportCombinations($employees);

        foreach ($statusPlan as $index => $status) {
            [$employee, $weekOffset] = $combinations->get($index);
            $weekStart = $this->weekStartFor($weekOffset);
            $createdAt = $this->createdAtFor($weekStart);

            WeeklyReport::factory()
                ->for($employee)
                ->create([
                    ...$this->workflowAttributes($status, $createdAt, $managers, $superAdmin, $index),
                    'department' => $employee->department,
                    'week' => $weekStart->format('o-\WW'),
                    'created_at' => $createdAt,
                ]);
        }
    }

    /** @return Collection<int, ReportStatus> */
    private function statusPlan(): Collection
    {
        return collect([
            ...array_fill(0, 15, ReportStatus::DRAFT),
            ...array_fill(0, 26, ReportStatus::SUBMITTED),
            ...array_fill(0, 24, ReportStatus::UNDER_REVIEW),
            ...array_fill(0, 43, ReportStatus::APPROVED),
            ...array_fill(0, 13, ReportStatus::REJECTED),
        ])->shuffle()->take(self::TARGET_REPORTS)->values();
    }

    /**
     * @param Collection<int, Employee> $employees
     * @return Collection<int, array{0: Employee, 1: int}>
     */
    private function reportCombinations(Collection $employees): Collection
    {
        return $employees
            ->flatMap(fn (Employee $employee) => collect(range(0, 11))
                ->map(fn (int $weekOffset) => [$employee, $weekOffset]))
            ->shuffle()
            ->values();
    }

    private function weekStartFor(int $weekOffset): CarbonImmutable
    {
        return CarbonImmutable::now()
            ->startOfWeek(CarbonInterface::MONDAY)
            ->subWeeks($weekOffset);
    }

    private function createdAtFor(CarbonImmutable $weekStart): CarbonImmutable
    {
        return $weekStart
            ->addDays(fake()->numberBetween(0, 4))
            ->setTime(fake()->numberBetween(8, 17), fake()->randomElement([0, 15, 30, 45]));
    }

    /**
     * @param Collection<int, User> $managers
     * @return array<string, mixed>
     */
    private function workflowAttributes(
        ReportStatus $status,
        CarbonImmutable $createdAt,
        Collection $managers,
        User $superAdmin,
        int $index,
    ): array {
        $attributes = [
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
            'updated_at' => $this->after($createdAt, 1, 16),
        ];

        if ($status === ReportStatus::DRAFT) {
            return $attributes;
        }

        $submittedAt = $this->after($createdAt, 6, 36);
        $manager = $managers->random();

        $attributes['submitted_at'] = $submittedAt;
        $attributes['updated_at'] = $submittedAt;

        if ($status === ReportStatus::SUBMITTED) {
            return $attributes;
        }

        $underReviewAt = $this->after($submittedAt, 4, 36);
        $managerComment = fake()->randomElement([
            'Reviewed the report; metrics are clear and risks are documented.',
            'Good progress. Please keep an eye on the dependency noted in difficulties.',
            'Ready for final approval with a concise executive summary.',
            'Manager review complete; no blocking corrections required.',
        ]);

        if ($status === ReportStatus::UNDER_REVIEW) {
            return [
                ...$attributes,
                'under_review_at' => $underReviewAt,
                'validated_at' => $underReviewAt,
                'validated_by' => $manager->id,
                'manager_comment' => $managerComment,
                'updated_at' => $underReviewAt,
            ];
        }

        if ($status === ReportStatus::APPROVED) {
            $approvedAt = $this->after($underReviewAt, 4, 48);

            return [
                ...$attributes,
                'under_review_at' => $underReviewAt,
                'validated_at' => $underReviewAt,
                'validated_by' => $manager->id,
                'approved_at' => $approvedAt,
                'approved_by' => $superAdmin->id,
                'manager_comment' => $managerComment,
                'generated_at' => $approvedAt,
                'pptx_file' => sprintf('reports/demo/weekly-report-%03d.pptx', $index + 1),
                'updated_at' => $approvedAt,
            ];
        }

        $rejectedAfterManagerReview = $index % 4 === 0;
        $reviewedAt = $rejectedAfterManagerReview ? $underReviewAt : null;
        $rejectedAt = $this->after($reviewedAt ?? $submittedAt, 4, 36);

        return [
            ...$attributes,
            'under_review_at' => $reviewedAt,
            'validated_at' => $reviewedAt,
            'validated_by' => $reviewedAt ? $manager->id : null,
            'manager_comment' => $reviewedAt ? $managerComment : null,
            'rejected_at' => $rejectedAt,
            'rejected_by' => $reviewedAt ? $superAdmin->id : $manager->id,
            'rejection_reason' => fake()->randomElement([
                'Please add measurable outcomes before resubmitting.',
                'The blockers need clearer ownership and follow-up dates.',
                'Some activities are missing supporting details.',
                'The next actions need to be aligned with department priorities.',
            ]),
            'updated_at' => $rejectedAt,
        ];
    }

    private function after(CarbonImmutable $base, int $minHours, int $maxHours): CarbonImmutable
    {
        $candidate = $base
            ->addHours(fake()->numberBetween($minHours, $maxHours))
            ->addMinutes(fake()->randomElement([0, 15, 30, 45]));
        $latest = CarbonImmutable::now()->subMinutes(30);

        if ($candidate->lessThanOrEqualTo($latest)) {
            return $candidate;
        }

        return $base->lessThan($latest) ? $latest : $base;
    }
}
