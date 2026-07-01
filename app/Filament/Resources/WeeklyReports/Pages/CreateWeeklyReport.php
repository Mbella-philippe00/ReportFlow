<?php

namespace App\Filament\Resources\WeeklyReports\Pages;

use App\Filament\Resources\WeeklyReports\WeeklyReportResource;
use App\Models\Employee;
use Filament\Resources\Pages\CreateRecord;

class CreateWeeklyReport extends CreateRecord
{
    protected static string $resource = WeeklyReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        if ($user->hasRole('employee')) {

            $employee = Employee::where('user_id', $user->id)->first();

            if ($employee) {
                $data['employee_id'] = $employee->id;
                $data['department'] = $employee->department;
            }
        }

        return $data;
    }
}
