<?php

namespace App\Filament\Widgets;

use App\Models\WeeklyReport;
use Filament\Widgets\ChartWidget;

class ReportsByStatusChart extends ChartWidget
{
    protected ?string $heading = 'Rapports par statut';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Nombre de rapports',
                    'data' => [
                        WeeklyReport::where('status', 'draft')->count(),
                        WeeklyReport::where('status', 'submitted')->count(),
                        WeeklyReport::where('status', 'rejected')->count(),
                        WeeklyReport::where('status', 'generated')->count(),
                    ],
                ],
            ],

            'labels' => [
                'Brouillon',
                'Soumis',
                'Rejetés',
                'Validés',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}