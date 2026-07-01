<?php

namespace App\Filament\Resources\WeeklyReports\Tables;

use App\Enums\ReportStatus;
use App\Models\Employee;
use App\Models\WeeklyReport;
use App\Services\ExcelReportGenerator;
use App\Services\Reports\ReportValidationService;
use App\Services\Reports\ReportWorkflowService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class WeeklyReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('employee.full_name')
                    ->label('Employé')
                    ->searchable(),

                TextColumn::make('department')
                    ->label('Département')
                    ->searchable(),

                TextColumn::make('week')
                    ->label('Semaine')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn (ReportStatus $state) => $state->label())
                    ->color(fn (ReportStatus $state) => $state->color()),

                TextColumn::make('validator.name')
                    ->label('Validé par')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('rejector.name')
                    ->label('Rejeté par')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('submitted_at')
                    ->label('Soumis le')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('validated_at')
                    ->label('Validé le')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('rejected_at')
                    ->label('Rejeté le')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('rejection_reason')
                    ->label('Motif')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('executive_summary')
                    ->label('Résumé IA')
                    ->limit(80)
                    ->toggleable(),
            ])

            ->filters([

                SelectFilter::make('week')
                    ->label('Semaine')
                    ->options(
                        WeeklyReport::query()
                            ->distinct()
                            ->orderByDesc('week')
                            ->pluck('week', 'week')
                            ->toArray()
                    ),

                SelectFilter::make('status')
                    ->label('Statut')
                    ->options(
                        collect(ReportStatus::cases())
                            ->mapWithKeys(fn (ReportStatus $status) => [
                                $status->value => $status->label(),
                            ])
                            ->toArray()
                    ),

                SelectFilter::make('department')
                    ->label('Département')
                    ->options(
                        WeeklyReport::query()
                            ->whereNotNull('department')
                            ->distinct()
                            ->pluck('department', 'department')
                            ->toArray()
                    ),

                SelectFilter::make('employee_id')
                    ->label('Employé')
                    ->options(
                        Employee::all()
                            ->pluck('full_name', 'id')
                            ->toArray()
                    ),
            ])

            ->recordActions([
                Action::make('download')
                    ->label('Télécharger')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->visible(
                        fn ($record) => $record->isGenerated()
                            && filled($record->pptx_file)
                    )
                    ->url(fn ($record) => Storage::url($record->pptx_file))
                    ->openUrlInNewTab(),

                Action::make('submit')
                    ->label('Soumettre')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('primary')
                    ->visible(
                        fn ($record) => auth()->user()->hasRole('employee')
                            && $record->isDraft()
                    )
                    ->requiresConfirmation()
                    ->action(function ($record) {

                        app(ReportWorkflowService::class)
                            ->submit($record);

                        Notification::make()
                            ->title('Rapport soumis avec succès')
                            ->success()
                            ->send();
                    }),

                Action::make('validate')
                    ->label('Pré-valider')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(
                        fn ($record) => auth()->user()->hasAnyRole([
                            'manager',
                            'super-admin',
                        ])
                            && $record->isSubmitted()
                    )
                    ->requiresConfirmation()
                    ->action(function ($record) {

                        app(ReportValidationService::class)
                            ->managerApprove($record);

                        Notification::make()
                            ->title('Rapport pré-validé')
                            ->success()
                            ->send();
                    }),

                Action::make('finalValidate')
                    ->label('Validation finale')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(
                        fn ($record) => auth()->user()->hasRole('super-admin')
                            && $record->isManagerApproved()
                    )
                    ->requiresConfirmation()
                    ->action(function ($record) {

                        app(ReportValidationService::class)
                            ->finalApprove($record);

                        Notification::make()
                            ->title('Rapport validé définitivement')
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Rejeter')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(
                        fn ($record) => auth()->user()->hasAnyRole([
                            'manager',
                            'super-admin',
                        ])
                            && $record->isSubmitted()
                    )
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Motif du rejet')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function ($record, array $data) {

                        app(ReportValidationService::class)
                            ->reject(
                                $record,
                                $data['rejection_reason']
                            );

                        Notification::make()
                            ->title('Rapport rejeté')
                            ->warning()
                            ->send();
                    }),

                EditAction::make(),
            ])
            ->toolbarActions([

                Action::make('exportExcel')
                    ->label('Exporter Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->visible(
                        fn () => auth()->user()->hasAnyRole([
                            'manager',
                            'super-admin',
                        ])
                    )
                    ->action(function () {

                        $path = app(
                            ExcelReportGenerator::class
                        )->generate();

                        return redirect(
                            Storage::url($path)
                        );
                    }),

                BulkActionGroup::make([

                    DeleteBulkAction::make()
                        ->visible(
                            fn () => auth()->user()->hasAnyRole([
                                'manager',
                                'super-admin',
                            ])
                        ),

                ]),

            ]);
    }
}
