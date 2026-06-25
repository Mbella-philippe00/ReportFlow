<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopEmployees extends BaseWidget
{
    protected static ?string $heading = 'Top 5 employés';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Employee::query()
                    ->withCount('weeklyReports')
                    ->orderByDesc('weekly_reports_count')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Employé'),

                Tables\Columns\TextColumn::make('department')
                    ->label('Département'),

                Tables\Columns\TextColumn::make('weekly_reports_count')
                    ->label('Rapports')
                    ->badge()
                    ->color('success'),
            ]);
    }
}