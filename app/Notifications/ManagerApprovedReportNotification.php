<?php

namespace App\Notifications;

use App\Models\WeeklyReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ManagerApprovedReportNotification extends Notification
{
    use Queueable;

    public function __construct(
        public WeeklyReport $report,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Report under review')
            ->greeting('Hello')
            ->line("The {$this->report->week} weekly report was moved under review by a manager.")
            ->line('Final approval is required.');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'workflow',
            'title' => 'Report under review',
            'message' => "The {$this->report->week} weekly report was moved under review by a manager.",
            'report_id' => $this->report->id,
            'employee_id' => $this->report->employee_id,
            'manager_comment' => $this->report->manager_comment,
            'action_url' => "/workflow/approvals/{$this->report->id}",
        ];
    }
}
