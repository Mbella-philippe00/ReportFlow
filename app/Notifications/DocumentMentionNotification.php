<?php

namespace App\Notifications;

use App\Models\DocumentComment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentMentionNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly DocumentComment $comment)
    {
    }

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('You were mentioned in a document comment')
            ->line("You were mentioned on {$this->comment->document->title}.")
            ->action('View report', url('/reports/'.$this->comment->document->weekly_report_id));
    }

    /** @return array<string, mixed> */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'document_mention',
            'title' => 'You were mentioned in a document comment',
            'message' => $this->comment->user?->name.' mentioned you on '.$this->comment->document->title.'.',
            'report_id' => $this->comment->document->weekly_report_id,
            'document_id' => $this->comment->report_document_id,
            'comment_id' => $this->comment->id,
            'action_url' => '/reports/'.$this->comment->document->weekly_report_id,
        ];
    }

    /** @return array<string, mixed> */
    public function toDatabase(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }
}
