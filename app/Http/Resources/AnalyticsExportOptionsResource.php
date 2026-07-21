<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalyticsExportOptionsResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'supported' => $this->resource['supported'],
            'available_formats' => $this->resource['available_formats'],
            'message' => $this->resource['message'],
            'future_formats' => $this->resource['future_formats'],
            'datasets' => $this->resource['datasets'] ?? [],
        ];
    }
}
