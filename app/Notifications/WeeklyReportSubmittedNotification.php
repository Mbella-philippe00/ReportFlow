<?php

namespace App\Notifications;

use App\Models\WeeklyReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WeeklyReportSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public WeeklyReport $report
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'workflow',
            'title' => 'Report submitted',
            'message' => $this->report->employee->full_name.' submitted the '.$this->report->week.' weekly report.',
            'report_id' => $this->report->id,
            'employee_id' => $this->report->employee_id,
            'action_url' => "/workflow/approvals/{$this->report->id}",
        ];
    }
}
