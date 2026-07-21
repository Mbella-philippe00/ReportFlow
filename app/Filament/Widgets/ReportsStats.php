<?php

namespace App\Filament\Widgets;

use App\Enums\ReportStatus;
use App\Models\WeeklyReport;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReportsStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalReports = WeeklyReport::count();

        $submitted = WeeklyReport::where('status', ReportStatus::SUBMITTED)->count();

        $generated = WeeklyReport::where('status', ReportStatus::APPROVED)->count();

        $rejected = WeeklyReport::where('status', ReportStatus::REJECTED)->count();

        $validationRate = $totalReports > 0
            ? round(($generated / $totalReports) * 100, 1)
            : 0;

        $rejectionRate = $totalReports > 0
            ? round(($rejected / $totalReports) * 100, 1)
            : 0;

        return [

            Stat::make(
                'Rapports',
                $totalReports
            )
                ->description('Total des rapports')
                ->color('primary'),

            Stat::make(
                'À valider',
                $submitted
            )
                ->description('En attente')
                ->color('warning'),

            Stat::make(
                'Taux validation',
                $validationRate.'%'
            )
                ->description('Rapports validés')
                ->color('success'),

            Stat::make(
                'Taux rejet',
                $rejectionRate.'%'
            )
                ->description('Rapports rejetés')
                ->color('danger'),

        ];
    }
}
