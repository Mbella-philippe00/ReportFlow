<?php

namespace App\Policies;

use App\Models\ReportDocument;
use App\Models\User;
use App\Models\WeeklyReport;
use Illuminate\Support\Facades\Gate;

class ReportDocumentPolicy
{
    public function viewAny(User $user, WeeklyReport $report): bool
    {
        return Gate::forUser($user)->allows('view', $report);
    }

    public function view(User $user, ReportDocument $reportDocument): bool
    {
        return Gate::forUser($user)->allows('view', $reportDocument->report);
    }

    public function create(User $user, WeeklyReport $report): bool
    {
        return Gate::forUser($user)->allows('view', $report)
            && $user->hasAnyRole(['employee', 'manager', 'super-admin']);
    }

    public function update(User $user, ReportDocument $reportDocument): bool
    {
        return $this->view($user, $reportDocument)
            && ($this->ownsDocument($user, $reportDocument) || $user->hasAnyRole(['manager', 'super-admin']));
    }

    public function delete(User $user, ReportDocument $reportDocument): bool
    {
        return $this->update($user, $reportDocument);
    }

    public function uploadVersion(User $user, ReportDocument $reportDocument): bool
    {
        return $this->view($user, $reportDocument)
            && $user->hasAnyRole(['employee', 'manager', 'super-admin']);
    }

    public function comment(User $user, ReportDocument $reportDocument): bool
    {
        return $this->view($user, $reportDocument);
    }

    public function download(User $user, ReportDocument $reportDocument): bool
    {
        return $this->view($user, $reportDocument);
    }

    public function preview(User $user, ReportDocument $reportDocument): bool
    {
        return $this->view($user, $reportDocument);
    }

    public function viewActivity(User $user, ReportDocument $reportDocument): bool
    {
        return $this->view($user, $reportDocument);
    }

    private function ownsDocument(User $user, ReportDocument $reportDocument): bool
    {
        return $reportDocument->uploaded_by_id !== null && $reportDocument->uploaded_by_id === $user->id;
    }
}
