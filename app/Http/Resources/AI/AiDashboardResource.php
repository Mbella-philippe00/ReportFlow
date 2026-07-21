<?php

namespace App\Http\Resources\AI;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AiDashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_generations' => $this->resource['total_generations'],
            'today_generations' => $this->resource['today_generations'],
            'available_actions' => $this->resource['available_actions'],
            'providers' => $this->resource['providers'],
            'by_action' => $this->resource['by_action'],
            'recent' => AiHistoryResource::collection($this->resource['recent']),
        ];
    }
}
