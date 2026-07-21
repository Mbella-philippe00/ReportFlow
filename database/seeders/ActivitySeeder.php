<?php

namespace Database\Seeders;

use App\Enums\ReportStatus;
use App\Models\User;
use App\Models\WeeklyReport;
use Carbon\CarbonImmutable;
use DateTimeInterface;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $managers = User::role('manager')->get();
        $superAdmin = User::role('super-admin')->first();

        WeeklyReport::query()
            ->with('employee.user', 'validator', 'approver', 'rejector')
            ->whereNotNull('submitted_at')
            ->orderBy('submitted_at')
            ->get()
            ->each(function (WeeklyReport $report) use ($managers, $superAdmin): void {
                $employeeUser = $report->employee?->user;

                if ($employeeUser) {
                    $this->logWorkflowActivity(
                        $report,
                        $employeeUser,
                        'submitted',
                        'Report submitted',
                        $report->submitted_at,
                        ['week' => $report->week, 'department' => $report->department]
                    );
                }

                if ($report->under_review_at !== null || $report->validated_at !== null) {
                    $this->logWorkflowActivity(
                        $report,
                        $report->validator ?? $managers->random(),
                        'under_review',
                        'Report moved under review',
                        $report->under_review_at ?? $report->validated_at,
                        [
                            'week' => $report->week,
                            'department' => $report->department,
                            'comment' => $report->manager_comment,
                        ]
                    );
                }

                if ($report->status === ReportStatus::APPROVED && ($report->approved_at !== null || $report->generated_at !== null) && $superAdmin) {
                    $this->logWorkflowActivity(
                        $report,
                        $report->approver ?? $superAdmin,
                        'approved',
                        'Report approved',
                        $report->approved_at ?? $report->generated_at,
                        [
                            'week' => $report->week,
                            'department' => $report->department,
                            'pptx_generated' => true,
                        ]
                    );
                }

                if ($report->status === ReportStatus::REJECTED && $report->rejected_at !== null) {
                    $this->logWorkflowActivity(
                        $report,
                        $report->rejector ?? $managers->random(),
                        'rejected',
                        'Report rejected',
                        $report->rejected_at,
                        [
                            'week' => $report->week,
                            'department' => $report->department,
                            'reason' => $report->rejection_reason,
                        ]
                    );
                }
            });
    }

    /** @param array<string, mixed> $properties */
    private function logWorkflowActivity(
        WeeklyReport $report,
        User $causer,
        string $event,
        string $description,
        DateTimeInterface $occurredAt,
        array $properties,
    ): void {
        $activity = activity()
            ->event($event)
            ->performedOn($report)
            ->causedBy($causer)
            ->withProperties($properties)
            ->log($description);

        if (! $activity) {
            return;
        }

        $occurredAt = CarbonImmutable::instance($occurredAt);

        $activity->forceFill([
            'created_at' => $occurredAt,
            'updated_at' => $occurredAt,
        ])->save();
    }
}
