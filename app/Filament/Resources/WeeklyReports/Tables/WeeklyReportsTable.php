<?php

namespace App\Filament\Resources\WeeklyReports\Tables;

use App\Services\PowerPointGenerator;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Mail\WeeklyReportValidatedMail;
use App\Mail\WeeklyReportRejectedMail;
use Illuminate\Support\Facades\Mail;
use App\Services\ExcelReportGenerator;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Filters\SelectFilter;
use App\Notifications\WeeklyReportSubmittedNotification;
use App\Models\user;
use App\Notifications\ManagerApprovedReportNotification;

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
                    ->label('Département'),


                TextColumn::make('status')
    ->label('Statut')
    ->badge()
    ->color(fn (string $state): string => match ($state) {
        'draft' => 'gray',
        'submitted' => 'warning',
        'manager_approved' => 'info',
        'generated' => 'success',
        'rejected' => 'danger',
        default => 'gray',
    }),
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
                    ->label('Motif rejet')
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
        \App\Models\WeeklyReport::query()
            ->distinct()
            ->orderByDesc('week')
            ->pluck('week', 'week')
            ->toArray()
    ),

    SelectFilter::make('status')
        ->label('Statut')
        ->options([
            'draft' => 'Brouillon',
            'submitted' => 'Soumis',
            'manager_approved' => 'Pré-validé',
            'generated' => 'Validé',
            'rejected' => 'Rejeté',
        ]),

    SelectFilter::make('department')
        ->label('Département')
        ->options(
            \App\Models\WeeklyReport::query()
                ->whereNotNull('department')
                ->distinct()
                ->pluck('department', 'department')
                ->toArray()
        ),

    SelectFilter::make('employee_id')
    ->label('Employé')
    ->options(
        \App\Models\Employee::all()
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
    fn ($record) =>
        $record->status === 'generated'
        && ! empty($record->pptx_file)
)
                    ->url(fn ($record) => Storage::url($record->pptx_file))
                    ->openUrlInNewTab(),

                Action::make('submit')
                    ->label('Soumettre')
                    ->icon('heroicon-o-paper-airplane')
                    ->visible(fn ($record) =>
                        auth()->user()->hasRole('employee')
                        && $record->status === 'draft'
                    )
                    ->action(function ($record) {

                        $record->update([
                            'status' => 'submitted',
                            'submitted_at' => now(),
                        ]);
                        if (empty($record->executive_summary)) {

    $summary = app(
        \App\Services\AI\WeeklyReportAiService::class
    )->generateExecutiveSummary($record);

    $record->update([
        'executive_summary' => $summary,
    ]);
}
                        $admins = \App\Models\User::role('super-admin')->get();

foreach ($admins as $admin) {
    $admin->notify(
        new \App\Notifications\WeeklyReportSubmittedNotification(
            $record
        )
    );
}
                        activity()
    ->performedOn($record)
    ->causedBy(auth()->user())
    ->withProperties([
        'week' => $record->week,
    ])
    ->log('Rapport soumis');

                        Notification::make()
                            ->title('Rapport soumis')
                            ->success()
                            ->send();
                    }),

                Action::make('validate')
                    ->label('Valider')
                    ->color('success')
                    ->visible(fn ($record) =>
                        auth()->user()->hasAnyRole([
                            'manager',
                            'super-admin',
                        ])
                        && $record->status === 'submitted'
                    )
                    
                    ->action(function ($record) {

    $record->update([
        'status' => 'manager_approved',
        'validated_at' => now(),
        'validated_by' => auth()->id(),
    ]);

    $superAdmins = \App\Models\User::role('super-admin')->get();

    foreach ($superAdmins as $admin) {
        $admin->notify(
            new \App\Notifications\ManagerApprovedReportNotification(
                $record
            )
        );
    }

    activity()
        ->performedOn($record)
        ->causedBy(auth()->user())
        ->withProperties([
            'week' => $record->week,
            'pptx_generated' => true,
        ])
        ->log('Rapport pré-validé par manager');

    if ($record->employee?->user?->email) {
        Mail::to($record->employee->user->email)
            ->send(new WeeklyReportValidatedMail($record));
    }

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
        fn ($record) =>
            auth()->user()->hasRole('super-admin')
            && $record->status === 'manager_approved'
    )
    ->action(function ($record) {

        $generator = app(
            \App\Services\PowerPointGenerator::class
        );

        $path = $generator->generate($record);

        $record->update([
    'status' => 'generated',
    'validated_at' => now(),
    'validated_by' => auth()->id(),
    'generated_at' => now(),
    'pptx_file' => $path,
]);

if ($record->employee?->user) {
    $record->employee->user->notify(
        new \App\Notifications\FinalReportApprovedNotification($record)
    );
}

activity()
    ->performedOn($record)
            ->causedBy(auth()->user())
            ->log('Rapport validé définitivement');

        \Filament\Notifications\Notification::make()
            ->title('Rapport validé définitivement')
            ->success()
            ->send();
    }),

                Action::make('reject')
                    ->label('Rejeter')
                    ->color('danger')
                    ->visible(fn ($record) =>
                        auth()->user()->hasAnyRole([
                            'manager',
                            'super-admin',
                        ])
                        && $record->status === 'submitted'
                    )
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Motif du rejet')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function ($record, array $data) {

                        $record->update([
                            'status' => 'rejected',
                            'rejected_at' => now(),
                            'rejected_by' => auth()->id(),
                            'rejection_reason' => $data['rejection_reason'],
                        ]);
                        activity()
    ->performedOn($record)
    ->causedBy(auth()->user())
    ->withProperties([
        'motif' => $data['rejection_reason'],
    ])
    ->log('Rapport rejeté');
                        if ($record->employee?->user?->email) {
    Mail::to($record->employee->user->email)
        ->send(new WeeklyReportRejectedMail($record));
}

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
        ->visible(fn () =>
            auth()->user()->hasAnyRole([
                'manager',
                'super-admin',
            ])
        )
        ->action(function () {

            $generator = app(
                ExcelReportGenerator::class
            );

            $path = $generator->generate();

            return redirect(
                Storage::url($path)
            );
        }),

    BulkActionGroup::make([
        DeleteBulkAction::make()
            ->visible(fn () =>
                auth()->user()->hasAnyRole([
                    'manager',
                    'super-admin',
                ])
            ),
    ]),

])
;
    }
}