<?php

namespace App\Filament\Resources\Employees\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

    TextColumn::make('first_name')
        ->label('Prénom')
        ->searchable()
        ->sortable(),

    TextColumn::make('last_name')
        ->label('Nom')
        ->searchable()
        ->sortable(),

    TextColumn::make('email')
        ->searchable(),

    TextColumn::make('department')
        ->label('Département')
        ->searchable(),

    IconColumn::make('active')
        ->label('Actif')
        ->boolean(),
        TextColumn::make('weekly_reports_count')
    ->label('Rapports')
    ->counts('weeklyReports')
    ->badge()
    ->color('success'),

TextColumn::make('validated_reports_count')
    ->label('Validés')
    ->state(fn ($record) =>
        $record->weeklyReports()
            ->where('status', 'generated')
            ->count()
    )
    ->badge()
    ->color('success'),

TextColumn::make('rejected_reports_count')
    ->label('Rejetés')
    ->state(fn ($record) =>
        $record->weeklyReports()
            ->where('status', 'rejected')
            ->count()
    )
    ->badge()
    ->color('danger'),

TextColumn::make('validation_rate')
    ->label('Taux validation')
    ->state(function ($record) {

        $total = $record->weeklyReports()->count();

        if ($total === 0) {
            return '0 %';
        }

        $validated = $record->weeklyReports()
            ->where('status', 'generated')
            ->count();

        return round(($validated / $total) * 100, 1) . ' %';
    })
    ->badge()
    ->color('info'),

    TextColumn::make('weekly_reports_count')
        ->label('Rapports')
        ->counts('weeklyReports')
        ->badge()
        ->color('success'),

    TextColumn::make('validated_reports_count')
        ->label('Validés')
        ->state(function ($record) {
            return $record->weeklyReports()
                ->where('status', 'generated')
                ->count();
        })
        ->badge()
        ->color('success'),

    TextColumn::make('rejected_reports_count')
        ->label('Rejetés')
        ->state(function ($record) {
            return $record->weeklyReports()
                ->where('status', 'rejected')
                ->count();
        })
        ->badge()
        ->color('danger'),
        TextColumn::make('validation_rate')
    ->label('Taux validation')
    ->state(function ($record) {

        $total = $record->weeklyReports()->count();

        if ($total === 0) {
            return '0%';
        }

        $validated = $record->weeklyReports()
            ->where('status', 'generated')
            ->count();

        return round(($validated / $total) * 100, 1) . '%';
    })
    ->badge()
    ->color(fn ($state) => str_replace('%', '', $state) >= 70
        ? 'success'
        : 'warning'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}