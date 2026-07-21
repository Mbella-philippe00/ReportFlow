<?php

namespace App\Notifications;

use App\Models\ReportDocument;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportDocumentUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly ReportDocument $document,
        private readonly string $event,
        private readonly ?User $actor = null,
    ) {
    }

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Report document updated')
            ->line($this->message())
            ->action('View report', url('/reports/'.$this->document->weekly_report_id));
    }

    /** @return array<string, mixed> */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'document',
            'title' => 'Report document updated',
            'message' => $this->message(),
            'report_id' => $this->document->weekly_report_id,
            'document_id' => $this->document->id,
            'event' => $this->event,
            'action_url' => '/reports/'.$this->document->weekly_report_id,
        ];
    }

    /** @return array<string, mixed> */
    public function toDatabase(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }

    private function message(): string
    {
        $actor = $this->actor?->name ?? 'A teammate';

        return match ($this->event) {
            'version_added' => "{$actor} uploaded a new version of {$this->document->title}.",
            'comment_added' => "{$actor} commented on {$this->document->title}.",
            default => "{$actor} uploaded {$this->document->title}.",
        };
    }
}
