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
            'title' => 'Rapport soumis',
            'message' => $this->report->employee->full_name.
                ' a soumis le rapport '.
                $this->report->week,

            'report_id' => $this->report->id,
        ];
    }
}
