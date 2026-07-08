<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @mixin DatabaseNotification
 */
class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $data = is_array($this->data) ? $this->data : [];
        $archivedAt = $this->dateValue($this->resource->archived_at ?? null);
        $readAt = $this->dateValue($this->read_at);

        return [
            'id' => $this->id,
            'type' => $this->notificationCategory($data),
            'notification_type' => class_basename($this->type),
            'title' => $this->title($data),
            'message' => $this->message($data),
            'data' => $data,
            'related' => [
                'report_id' => Arr::get($data, 'report_id'),
                'employee_id' => Arr::get($data, 'employee_id'),
                'user_id' => Arr::get($data, 'user_id'),
            ],
            'action_url' => $this->actionUrl($data),
            'is_read' => $readAt !== null,
            'is_unread' => $readAt === null,
            'is_archived' => $archivedAt !== null,
            'read_at' => $readAt,
            'archived_at' => $archivedAt,
            'created_at' => $this->dateValue($this->created_at),
            'updated_at' => $this->dateValue($this->updated_at),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function actionUrl(array $data): ?string
    {
        $directUrl = Arr::get($data, 'action_url')
            ?? Arr::get($data, 'url')
            ?? Arr::get($data, 'actions.0.url');

        if (is_string($directUrl) && trim($directUrl) !== '') {
            return $directUrl;
        }

        $reportId = Arr::get($data, 'report_id');

        if (is_numeric($reportId)) {
            return "/reports/{$reportId}";
        }

        $employeeId = Arr::get($data, 'employee_id');

        if (is_numeric($employeeId)) {
            return "/employees/{$employeeId}";
        }

        return null;
    }

    private function dateValue(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Carbon) {
            return $value->toISOString();
        }

        if ($value instanceof \DateTimeInterface) {
            return Carbon::instance($value)->toISOString();
        }

        if (is_string($value) && trim($value) !== '') {
            return Carbon::parse($value)->toISOString();
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function message(array $data): string
    {
        $message = Arr::get($data, 'message')
            ?? Arr::get($data, 'body')
            ?? Arr::get($data, 'description')
            ?? $this->title($data);

        return is_string($message) ? $message : 'Notification update.';
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function notificationCategory(array $data): string
    {
        $explicitType = Arr::get($data, 'type');

        if (is_string($explicitType) && $this->isSupportedType($explicitType)) {
            return Str::lower($explicitType);
        }

        $class = Str::lower(class_basename($this->type));

        return match (true) {
            Str::contains($class, 'ai') => 'ai',
            Str::contains($class, 'admin') => 'administration',
            Str::contains($class, 'employee') || Arr::has($data, 'employee_id') => 'employees',
            Str::contains($class, 'report') || Arr::has($data, 'report_id') => 'workflow',
            default => 'system',
        };
    }

    private function isSupportedType(string $type): bool
    {
        return in_array(Str::lower($type), [
            'administration',
            'ai',
            'employees',
            'reports',
            'system',
            'workflow',
        ], true);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function title(array $data): string
    {
        $title = Arr::get($data, 'title')
            ?? Arr::get($data, 'subject')
            ?? Arr::get($data, 'heading');

        return is_string($title) && trim($title) !== ''
            ? $title
            : Str::headline(class_basename($this->type));
    }
}
