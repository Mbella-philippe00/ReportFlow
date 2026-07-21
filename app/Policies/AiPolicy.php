<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeeklyReport;

class AiPolicy
{
    public function viewDashboard(User $user): bool
    {
        return $user->hasAnyRole(['manager', 'super-admin']);
    }

    public function viewHistory(User $user): bool
    {
        return $user->hasAnyRole(['employee', 'manager', 'super-admin']);
    }

    public function viewProviders(User $user): bool
    {
        return $user->hasAnyRole(['employee', 'manager', 'super-admin']);
    }

    public function useForReport(User $user, WeeklyReport $report): bool
    {
        return $user->hasAnyRole(['manager', 'super-admin'])
            || $report->employee?->user_id === $user->id;
    }

    public function recommendWorkflow(User $user, WeeklyReport $report): bool
    {
        return $user->hasAnyRole(['manager', 'super-admin']);
    }
}
