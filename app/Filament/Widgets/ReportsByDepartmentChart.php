<?php

namespace App\Filament\Widgets;

use App\Models\WeeklyReport;
use Filament\Widgets\ChartWidget;

class ReportsByDepartmentChart extends ChartWidget
{
    protected ?string $heading = 'Rapports par département';

    protected function getData(): array
    {
        $reports = WeeklyReport::query()
            ->selectRaw('department, COUNT(*) as total')
            ->groupBy('department')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Rapports',
                    'data' => $reports->pluck('total')->toArray(),
                ],
            ],

            'labels' => $reports->pluck('department')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
