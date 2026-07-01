<?php

namespace App\Filament\Widgets;

use App\Enums\ReportStatus;
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
                        WeeklyReport::where('status', ReportStatus::DRAFT)->count(),
                        WeeklyReport::where('status', ReportStatus::SUBMITTED)->count(),
                        WeeklyReport::where('status', ReportStatus::REJECTED)->count(),
                        WeeklyReport::where('status', ReportStatus::GENERATED)->count(),
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
