<?php

namespace App\Notifications;

use App\Models\WeeklyReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ManagerApprovedReportNotification extends Notification
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
        ->subject('Rapport pré-validé')
        ->greeting('Bonjour')
        ->line("Le rapport {$this->report->week} a été pré-validé par un manager.")
        ->line('Une validation finale est requise.');
}

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Rapport pré-validé',
            'message' => "Le rapport {$this->report->week} a été pré-validé par un manager.",
            'report_id' => $this->report->id,
        ];
    }
}