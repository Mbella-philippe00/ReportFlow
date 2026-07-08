<?php

namespace App\Notifications;

use App\Models\WeeklyReport;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
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
            ->subject('Rapport pré-validé')
            ->greeting('Bonjour')
            ->line("Le rapport {$this->report->week} a été pré-validé par un manager.")
            ->line('Une validation finale est requise.');
    }

    public function toDatabase(object $notifiable): array
    {
        return FilamentNotification::make()
            ->title('Rapport pré-validé')
            ->body("Le rapport {$this->report->week} a été pré-validé par un manager.")
            ->actions([
                Action::make('view')
                    ->label('Voir le rapport')
                    ->url("/admin/weekly-reports/{$this->report->id}/edit"),
            ])
            ->getDatabaseMessage();
    }
}
