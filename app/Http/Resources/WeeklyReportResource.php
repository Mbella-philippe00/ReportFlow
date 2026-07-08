<?php

namespace App\Http\Resources;

use App\Models\WeeklyReport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin WeeklyReport
 */
class WeeklyReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'employee' => [
                'id' => $this->employee?->id,
                'name' => $this->employee?->full_name,
                'email' => $this->employee?->email,
            ],

            'department' => $this->department,

            'week' => $this->week,
'status' => [
    'value' => $this->status->value,
    'label' => $this->status->label(),
    'color' => $this->status->color(),
],

            'objectives' => $this->objectives,

            'activities' => $this->activities,

            'achievements' => $this->achievements,

            'difficulties' => $this->difficulties,

            'next_actions' => $this->next_actions,

            'executive_summary' => $this->executive_summary,

            'pptx_file' => $this->pptx_file,

            'validator' => $this->validator?->name,

            'rejector' => $this->rejector?->name,

            'rejection_reason' => $this->rejection_reason,

            'submitted_at' => $this->submitted_at,

            'validated_at' => $this->validated_at,

            'generated_at' => $this->generated_at,

            'rejected_at' => $this->rejected_at,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,

        ];
    }
}
