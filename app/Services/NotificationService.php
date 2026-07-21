<?php

namespace App\Services;

use App\Models\User;
use App\Models\WeeklyReport;
use App\Notifications\FinalReportApprovedNotification;
use App\Notifications\ManagerApprovedReportNotification;
use App\Notifications\WeeklyReportRejectedNotification;
use App\Notifications\WeeklyReportSubmittedNotification;

class NotificationService
{
    public function notifyManagers(WeeklyReport $report): void
    {
        User::role('manager')
            ->get()
            ->each(fn (User $manager) => $manager->notify(
                new WeeklyReportSubmittedNotification($report)
            ));
    }

    public function notifySuperAdmins(WeeklyReport $report): void
    {
        User::role('super-admin')
            ->get()
            ->each(fn (User $admin) => $admin->notify(
                new ManagerApprovedReportNotification($report)
            ));
    }

    public function notifyEmployee(WeeklyReport $report): void
    {
        if ($report->employee?->user) {
            $report->employee->user->notify(
                new FinalReportApprovedNotification($report)
            );
        }
    }

    public function notifyEmployeeRejected(WeeklyReport $report): void
    {
        if ($report->employee?->user) {
            $report->employee->user->notify(
                new WeeklyReportRejectedNotification($report)
            );
        }
    }
}
