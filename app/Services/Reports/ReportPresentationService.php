<?php

namespace App\Services\Reports;

use App\Models\WeeklyReport;
use App\Services\PowerPointGenerator;

class ReportPresentationService
{
    public function __construct(
        protected PowerPointGenerator $generator,
    ) {}

    public function generatePowerPoint(
        WeeklyReport $report
    ): string {

        $path = $this->generator->generate($report);

        $report->update([
            'pptx_file' => $path,
            'generated_at' => now(),
        ]);

        return $path;
    }
}