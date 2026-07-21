<?php

namespace Database\Seeders;

use App\Enums\ReportStatus;
use App\Models\User;
use App\Models\WeeklyReport;
use Carbon\CarbonImmutable;
use Database\Factories\NotificationFactory;
use DateTimeInterface;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $managers = User::role('manager')->get();
        $superAdmins = User::role('super-admin')->get();

        WeeklyReport::query()
            ->with('employee.user')
            ->whereNotNull('submitted_at')
            ->orderBy('submitted_at')
            ->get()
            ->each(function (WeeklyReport $report) use ($managers, $superAdmins): void {
                foreach ($managers as $manager) {
                    $this->createNotification($manager, $report, 'submitted', $report->submitted_at);
                }

                if ($report->under_review_at !== null || $report->validated_at !== null) {
                    foreach ($superAdmins as $superAdmin) {
                        $this->createNotification(
                            $superAdmin,
                            $report,
                            'under_review',
                            $report->under_review_at ?? $report->validated_at,
                        );
                    }
                }

                if ($report->status === ReportStatus::APPROVED && ($report->approved_at !== null || $report->generated_at !== null)) {
                    $this->createForEmployee($report, 'approved', $report->approved_at ?? $report->generated_at);
                }

                if ($report->status === ReportStatus::REJECTED && $report->rejected_at !== null) {
                    $this->createForEmployee($report, 'rejected', $report->rejected_at);
                }
            });
    }

    private function createForEmployee(WeeklyReport $report, string $workflowEvent, DateTimeInterface $createdAt): void
    {
        $user = $report->employee?->user;

        if (! $user) {
            return;
        }

        $this->createNotification($user, $report, $workflowEvent, $createdAt);
    }

    private function createNotification(User $user, WeeklyReport $report, string $workflowEvent, DateTimeInterface $createdAt): void
    {
        $factory = NotificationFactory::new()->forUser($user);

        $factory = match ($workflowEvent) {
            'under_review' => $factory->managerApproved($report),
            'approved' => $factory->finalApproved($report),
            'rejected' => $factory->reportRejected($report),
            default => $factory->reportSubmitted($report),
        };

        $factory->create($this->timestampsFor($createdAt));
    }

    /** @return array<string, DateTimeInterface|null> */
    private function timestampsFor(DateTimeInterface $createdAt): array
    {
        $created = CarbonImmutable::instance($createdAt);
        $readAt = fake()->boolean(68) ? $this->after($created, 1, 72) : null;
        $archivedAt = $readAt && fake()->boolean(9)
            ? $this->after($readAt, 12, 168)
            : null;

        return [
            'created_at' => $created,
            'updated_at' => $archivedAt ?? $readAt ?? $created,
            'read_at' => $readAt,
            'archived_at' => $archivedAt,
        ];
    }

    private function after(CarbonImmutable $base, int $minHours, int $maxHours): CarbonImmutable
    {
        $candidate = $base
            ->addHours(fake()->numberBetween($minHours, $maxHours))
            ->addMinutes(fake()->randomElement([0, 15, 30, 45]));
        $latest = CarbonImmutable::now()->subMinutes(15);

        if ($candidate->lessThanOrEqualTo($latest)) {
            return $candidate;
        }

        return $base->lessThan($latest) ? $latest : $base;
    }
}
