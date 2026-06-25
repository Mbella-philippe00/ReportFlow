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
            ->subject('Rapport validé')
            ->greeting('Bonjour')
            ->line("Votre rapport {$this->report->week} a été validé définitivement.")
            ->line('Le fichier PowerPoint est désormais disponible.')
            ->success();
    }

   public function toDatabase(object $notifiable): array
{
    return [
        'title' => 'Rapport validé',
        'message' => "Votre rapport {$this->report->week} a été validé définitivement.",
        'report_id' => $this->report->id,
    ];
}
}