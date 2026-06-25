<?php

namespace App\Filament\Widgets;

use App\Models\WeeklyReport;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class PendingReports extends TableWidget
{
    protected static ?string $heading = 'Rapports en attente de validation';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                WeeklyReport::query()
                    ->where('status', 'submitted')
                    ->latest()
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

                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Soumis le')
                    ->dateTime('d/m/Y H:i'),

            ])
            ->paginated(false);
    }
}