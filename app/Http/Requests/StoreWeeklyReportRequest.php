<?php

namespace App\Http\Requests;

use App\Models\WeeklyReport;
use Illuminate\Foundation\Http\FormRequest;

class StoreWeeklyReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', WeeklyReport::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'exists:employees,id'],
            'department' => ['required', 'string', 'max:255'],
            'week' => ['required', 'string', 'max:20'],
            'objectives' => ['required', 'string'],
            'activities' => ['required', 'string'],
            'achievements' => ['required', 'string'],
            'difficulties' => ['nullable', 'string'],
            'next_actions' => ['required', 'string'],
        ];
    }
}
