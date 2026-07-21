<?php

namespace App\Http\Resources\AI;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AiGenerationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'action' => $this->resource['action'],
            'content' => $this->resource['content'],
            'provider' => $this->resource['provider'],
            'model' => $this->resource['model'],
            'history_id' => $this->resource['history_id'],
            'metadata' => $this->resource['metadata'],
            'report' => [
                'id' => $this->resource['report']?->id,
                'week' => $this->resource['report']?->week,
                'department' => $this->resource['report']?->department,
                'status' => $this->resource['report']?->status?->value,
                'executive_summary' => $this->resource['report']?->executive_summary,
            ],
            'created_at' => $this->resource['created_at'],
        ];
    }
}
