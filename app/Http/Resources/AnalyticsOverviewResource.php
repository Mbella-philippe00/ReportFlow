<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalyticsOverviewResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_reports' => $this->resource['total_reports'],
            'submitted_reports' => $this->resource['submitted_reports'],
            'approved_reports' => $this->resource['approved_reports'],
            'rejected_reports' => $this->resource['rejected_reports'],
            'generated_reports' => $this->resource['generated_reports'],
            'pending_reports' => $this->resource['pending_reports'],
            'validation_rate' => $this->resource['validation_rate'],
            'completion_rate' => $this->resource['completion_rate'],
            'average_approval_time' => $this->resource['average_approval_time'],
            'status_distribution' => $this->resource['status_distribution'],
        ];
    }
}
