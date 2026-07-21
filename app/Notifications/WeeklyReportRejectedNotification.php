<?php

namespace App\Notifications;

use App\Models\WeeklyReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WeeklyReportRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public WeeklyReport $report
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Report rejected')
            ->greeting('Hello')
            ->line("Your weekly report {$this->report->week} was rejected.")
            ->line($this->report->rejection_reason ?? 'Please review the manager feedback before resubmitting.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'workflow',
            'title' => 'Report rejected',
            'message' => "Your {$this->report->week} weekly report needs revisions before approval.",
            'report_id' => $this->report->id,
            'employee_id' => $this->report->employee_id,
            'reason' => $this->report->rejection_reason,
            'action_url' => "/reports/{$this->report->id}/edit",
        ];
    }
}
