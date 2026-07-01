<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'statistics' => $this['statistics'],

            'recent_reports' => WeeklyReportResource::collection(
                $this['recent_reports']
            ),

            'pending_reports' => WeeklyReportResource::collection(
                $this['pending_reports']
            ),

            'charts' => $this['charts'],
        ];
    }
}
