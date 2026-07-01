<?php

namespace App\Filament\Resources\WeeklyReports;

use App\Filament\Resources\WeeklyReports\Pages\CreateWeeklyReport;
use App\Filament\Resources\WeeklyReports\Pages\EditWeeklyReport;
use App\Filament\Resources\WeeklyReports\Pages\ListWeeklyReports;
use App\Filament\Resources\WeeklyReports\Schemas\WeeklyReportForm;
use App\Filament\Resources\WeeklyReports\Tables\WeeklyReportsTable;
use App\Models\WeeklyReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WeeklyReportResource extends Resource
{
    protected static ?string $model = WeeklyReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return WeeklyReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WeeklyReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with('employee');

        $user = auth()->user();

        // Super Admin : voit tout
        if ($user?->hasRole('super-admin')) {
            return $query;
        }

        // Manager : voit uniquement les rapports de son département
        if ($user?->hasRole('manager')) {

            $department = $user->employee?->department;

            return $query->where(
                'department',
                $department
            );
        }

        // Employee : voit uniquement ses rapports
        if ($user?->hasRole('employee')) {

            return $query->whereHas('employee', function ($q) use ($user) {

                $q->where(
                    'user_id',
                    $user->id
                );
            });
        }

        // Aucun rôle reconnu
        return $query->whereRaw('1 = 0');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWeeklyReports::route('/'),
            'create' => CreateWeeklyReport::route('/create'),
            'edit' => EditWeeklyReport::route('/{record}/edit'),
        ];
    }
}
