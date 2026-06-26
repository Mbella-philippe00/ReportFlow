<?php

namespace App\Services;

use App\Models\User;
use App\Models\WeeklyReport;
use App\Notifications\FinalReportApprovedNotification;
use App\Notifications\ManagerApprovedReportNotification;
use App\Notifications\WeeklyReportSubmittedNotification;

class NotificationService
{
    /**
     * Notifie tous les managers qu'un rapport a été soumis.
     */
    public function notifyManagers(WeeklyReport $report): void
    {
        User::role('manager')
            ->get()
            ->each(fn (User $manager) => $manager->notify(
                new WeeklyReportSubmittedNotification($report)
            ));
    }

    /**
     * Notifie tous les super administrateurs qu'un rapport
     * a été pré-validé.
     */
    public function notifySuperAdmins(WeeklyReport $report): void
    {
        User::role('super-admin')
            ->get()
            ->each(fn (User $admin) => $admin->notify(
                new ManagerApprovedReportNotification($report)
            ));
    }

    /**
     * Notifie l'employé que son rapport a été validé.
     */
    public function notifyEmployee(WeeklyReport $report): void
    {
        if ($report->employee?->user) {
            $report->employee->user->notify(
                new FinalReportApprovedNotification($report)
            );
        }
    }
}