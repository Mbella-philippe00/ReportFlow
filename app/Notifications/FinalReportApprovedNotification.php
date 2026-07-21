<?php

namespace App\Notifications;

use App\Models\WeeklyReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FinalReportApprovedNotification extends Notification
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
            ->subject('Report approved')
            ->greeting('Hello')
            ->line("Your weekly report {$this->report->week} was approved.")
            ->line('The PowerPoint file is available when generated.')
            ->success();
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'workflow',
            'title' => 'Report approved',
            'message' => "Your {$this->report->week} weekly report was approved.",
            'report_id' => $this->report->id,
            'employee_id' => $this->report->employee_id,
            'action_url' => "/reports/{$this->report->id}",
        ];
    }
}
