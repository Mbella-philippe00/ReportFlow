<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WeeklyReport;
use App\Notifications\FinalReportApprovedNotification;
use App\Notifications\ManagerApprovedReportNotification;
use App\Notifications\WeeklyReportSubmittedNotification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;

/**
 * @extends Factory<DatabaseNotification>
 */
class NotificationFactory extends Factory
{
    protected $model = DatabaseNotification::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'type' => WeeklyReportSubmittedNotification::class,
            'notifiable_type' => User::class,
            'notifiable_id' => User::factory(),
            'data' => [
                'type' => 'system',
                'title' => 'System notification',
                'message' => fake()->sentence(),
            ],
            'read_at' => fake()->boolean(60) ? fake()->dateTimeBetween('-30 days') : null,
        ];
    }

    public function forUser(User $user): static
    {
        return $this->state(fn () => [
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
        ]);
    }

    public function unread(): static
    {
        return $this->state(fn () => [
            'read_at' => null,
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn () => [
            'archived_at' => now(),
        ]);
    }

    public function reportSubmitted(WeeklyReport $report): static
    {
        return $this->state(fn () => [
            'type' => WeeklyReportSubmittedNotification::class,
            'data' => [
                'type' => 'workflow',
                'title' => 'Report submitted',
                'message' => "{$report->employee->full_name} submitted the {$report->week} weekly report.",
                'report_id' => $report->id,
                'employee_id' => $report->employee_id,
                'action_url' => "/reports/{$report->id}",
            ],
        ]);
    }

    public function managerApproved(WeeklyReport $report): static
    {
        return $this->state(fn () => [
            'type' => ManagerApprovedReportNotification::class,
            'data' => [
                'type' => 'workflow',
                'title' => 'Report under review',
                'message' => "The {$report->week} weekly report was moved under review by a manager.",
                'report_id' => $report->id,
                'employee_id' => $report->employee_id,
                'action_url' => "/admin/weekly-reports/{$report->id}/edit",
            ],
        ]);
    }

    public function finalApproved(WeeklyReport $report): static
    {
        return $this->state(fn () => [
            'type' => FinalReportApprovedNotification::class,
            'data' => [
                'type' => 'workflow',
                'title' => 'Report approved',
                'message' => "Your {$report->week} weekly report was approved and the presentation is available.",
                'report_id' => $report->id,
                'employee_id' => $report->employee_id,
                'action_url' => "/reports/{$report->id}",
            ],
        ]);
    }

    public function reportRejected(WeeklyReport $report): static
    {
        return $this->state(fn () => [
            'type' => 'App\\Notifications\\WeeklyReportRejectedNotification',
            'data' => [
                'type' => 'workflow',
                'title' => 'Report rejected',
                'message' => "Your {$report->week} weekly report needs revisions before approval.",
                'report_id' => $report->id,
                'employee_id' => $report->employee_id,
                'reason' => $report->rejection_reason,
                'action_url' => "/reports/{$report->id}",
            ],
        ]);
    }
}