<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWeeklyReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['sometimes', 'exists:employees,id'],

            'department' => ['sometimes', 'string', 'max:255'],

            'week' => ['sometimes', 'string', 'max:20'],

            'objectives' => ['sometimes', 'string'],

            'activities' => ['sometimes', 'string'],

            'achievements' => ['sometimes', 'string'],

            'difficulties' => ['nullable', 'string'],

            'next_actions' => ['sometimes', 'string'],
        ];
    }
}
