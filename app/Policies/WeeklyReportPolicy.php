<?php

namespace App\Policies;

use App\Enums\ReportStatus;
use App\Models\User;
use App\Models\WeeklyReport;

class WeeklyReportPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['employee', 'manager', 'super-admin']);
    }

    public function view(User $user, WeeklyReport $weeklyReport): bool
    {
        return $user->hasAnyRole(['manager', 'super-admin']) || $this->ownsReport($user, $weeklyReport);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['employee', 'manager', 'super-admin']);
    }

    public function update(User $user, WeeklyReport $weeklyReport): bool
    {
        if (! in_array($weeklyReport->status, [ReportStatus::DRAFT, ReportStatus::REJECTED], true)) {
            return false;
        }

        return $user->hasAnyRole(['manager', 'super-admin']) || $this->ownsReport($user, $weeklyReport);
    }

    public function delete(User $user, WeeklyReport $weeklyReport): bool
    {
        if ($weeklyReport->status !== ReportStatus::DRAFT) {
            return false;
        }

        return $user->hasAnyRole(['manager', 'super-admin']) || $this->ownsReport($user, $weeklyReport);
    }

    public function restore(User $user, WeeklyReport $weeklyReport): bool
    {
        return $user->hasRole('super-admin');
    }

    public function forceDelete(User $user, WeeklyReport $weeklyReport): bool
    {
        return $user->hasRole('super-admin');
    }

    public function submit(User $user, WeeklyReport $weeklyReport): bool
    {
        if (! in_array($weeklyReport->status, [ReportStatus::DRAFT, ReportStatus::REJECTED], true)) {
            return false;
        }

        return $user->hasAnyRole(['manager', 'super-admin']) || $this->ownsReport($user, $weeklyReport);
    }

    public function approve(User $user, WeeklyReport $weeklyReport): bool
    {
        return $weeklyReport->status === ReportStatus::SUBMITTED
            && $user->hasAnyRole(['manager', 'super-admin']);
    }

    public function finalApprove(User $user, WeeklyReport $weeklyReport): bool
    {
        return $weeklyReport->status === ReportStatus::UNDER_REVIEW
            && $user->hasRole('super-admin');
    }

    public function reject(User $user, WeeklyReport $weeklyReport): bool
    {
        return in_array($weeklyReport->status, [ReportStatus::SUBMITTED, ReportStatus::UNDER_REVIEW], true)
            && $user->hasAnyRole(['manager', 'super-admin']);
    }

    public function viewTimeline(User $user, WeeklyReport $weeklyReport): bool
    {
        return $this->view($user, $weeklyReport);
    }

    public function viewQueue(User $user): bool
    {
        return $user->hasAnyRole(['employee', 'manager', 'super-admin']);
    }

    private function ownsReport(User $user, WeeklyReport $weeklyReport): bool
    {
        return $user->employee?->id !== null
            && $user->employee->id === $weeklyReport->employee_id;
    }
}
