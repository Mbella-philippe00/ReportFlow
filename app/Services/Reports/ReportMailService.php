<?php

namespace App\Services\Reports;

use App\Mail\WeeklyReportRejectedMail;
use App\Mail\WeeklyReportValidatedMail;
use App\Models\WeeklyReport;
use Illuminate\Support\Facades\Mail;

class ReportMailService
{
    public function sendValidationMail(WeeklyReport $report): void
    {
        if (! $report->employee?->user?->email) {
            return;
        }

        Mail::to($report->employee->user->email)
            ->send(new WeeklyReportValidatedMail($report));
    }

    public function sendRejectionMail(WeeklyReport $report): void
    {
        if (! $report->employee?->user?->email) {
            return;
        }

        Mail::to($report->employee->user->email)
            ->send(new WeeklyReportRejectedMail($report));
    }
}
