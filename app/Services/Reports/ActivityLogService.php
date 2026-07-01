<?php

namespace App\Services\Reports;

use App\Models\WeeklyReport;

class ActivityLogService
{
    public function log(
        WeeklyReport $report,
        string $message,
        array $properties = []
    ): void {

        activity()
            ->performedOn($report)
            ->causedBy(auth()->user())
            ->withProperties($properties)
            ->log($message);
    }
}
