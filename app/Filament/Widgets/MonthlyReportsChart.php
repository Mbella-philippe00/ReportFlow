<?php

namespace App\Filament\Widgets;

use App\Models\WeeklyReport;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MonthlyReportsChart extends ChartWidget
{
    protected ?string $heading = 'Évolution mensuelle des rapports';

    protected function getData(): array
    {
        $reports = WeeklyReport::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = [
            1 => 'Jan',
            2 => 'Fév',
            3 => 'Mar',
            4 => 'Avr',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juil',
            8 => 'Août',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Déc',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Rapports',
                    'data' => $reports->pluck('total')->toArray(),
                ],
            ],

            'labels' => $reports
                ->pluck('month')
                ->map(fn ($month) => $months[$month] ?? $month)
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
