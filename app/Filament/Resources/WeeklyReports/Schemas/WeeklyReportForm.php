<?php

namespace App\Filament\Resources\WeeklyReports\Schemas;

use App\Models\Employee;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WeeklyReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // Super Admin : choix de l'employé
                Select::make('employee_id')
                    ->label('Employé')
                    ->options(
                        Employee::all()
                            ->pluck('full_name', 'id')
                    )
                    ->searchable()
                    ->required()
                    ->visible(fn () => auth()->user()?->hasRole('super-admin')),

                // Employee : employé affecté automatiquement
                Hidden::make('employee_id')
                    ->default(function () {
                        $employee = Employee::where(
                            'user_id',
                            auth()->id()
                        )->first();

                        return $employee?->id;
                    })
                    ->visible(fn () => auth()->user()?->hasRole('employee')),

                TextInput::make('department')
                    ->label('Département')
                    ->required(),

                TextInput::make('week')
                    ->label('Semaine')
                    ->required()
                    ->placeholder('2026-W24'),

                Textarea::make('objectives')
                    ->label('Objectifs')
                    ->rows(4),

                Textarea::make('activities')
                    ->label('Activités réalisées')
                    ->rows(5),

                Textarea::make('achievements')
                    ->label('Réalisations majeures')
                    ->rows(5),

                Textarea::make('difficulties')
                    ->label('Difficultés rencontrées')
                    ->rows(5),

                Textarea::make('next_actions')
                    ->label('Actions prévues')
                    ->rows(5),

                Textarea::make('executive_summary')
                    ->label('Résumé exécutif IA')
                    ->rows(8)
                    ->columnSpanFull(),

            ]);
    }
}
