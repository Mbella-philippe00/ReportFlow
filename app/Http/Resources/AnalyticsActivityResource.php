<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalyticsActivityResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource['id'],
            'description' => $this->resource['description'],
            'event' => $this->resource['event'],
            'type' => $this->resource['type'],
            'report_id' => $this->resource['report_id'],
            'causer' => $this->resource['causer'],
            'properties' => $this->resource['properties'],
            'occurred_at' => $this->resource['occurred_at'],
        ];
    }
}
