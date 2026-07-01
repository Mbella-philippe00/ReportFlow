<?php

namespace App\Filament\Resources\ActivityLogs\Tables;

use Filament\Tables;
use Filament\Tables\Table;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([

                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Utilisateur')
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Action')
                    ->badge()
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Objet')
                    ->formatStateUsing(
                        fn (?string $state) => class_basename($state)
                    ),

                Tables\Columns\TextColumn::make('subject_id')
                    ->label('ID Objet'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),

            ]);
    }
}
