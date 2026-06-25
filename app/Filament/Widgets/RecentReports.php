<?php

namespace App\Filament\Widgets;

use App\Models\WeeklyReport;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentReports extends TableWidget
{
    protected static ?string $heading = 'Rapports récents';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                WeeklyReport::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns([

                Tables\Columns\TextColumn::make('employee.full_name')
                    ->label('Employé')
                    ->searchable(),

                Tables\Columns\TextColumn::make('department')
                    ->label('Département')
                    ->badge(),

                Tables\Columns\TextColumn::make('week')
                    ->label('Semaine'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'submitted' => 'warning',
                        'generated' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i'),

            ])
            ->paginated(false);
    }
}