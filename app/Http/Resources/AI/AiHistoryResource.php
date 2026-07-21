<?php

namespace App\Http\Resources\AI;

use App\Models\WeeklyReport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Activitylog\Models\Activity;

/** @mixin Activity */
class AiHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $properties = $this->properties;
        $subject = $this->subject;

        return [
            'id' => $this->id,
            'action' => $properties->get('action'),
            'content' => $properties->get('content'),
            'provider' => $properties->get('provider'),
            'model' => $properties->get('model'),
            'section' => $properties->get('section'),
            'persisted' => (bool) $properties->get('persisted', false),
            'report' => $subject instanceof WeeklyReport ? [
                'id' => $subject->id,
                'week' => $subject->week,
                'department' => $subject->department,
                'status' => $subject->status->value,
            ] : null,
            'causer' => $this->causer ? [
                'id' => $this->causer->getKey(),
                'name' => $this->causer->name,
                'email' => $this->causer->email,
            ] : null,
            'created_at' => $this->created_at,
        ];
    }
}
