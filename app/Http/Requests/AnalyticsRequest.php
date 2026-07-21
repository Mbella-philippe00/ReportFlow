<?php

namespace App\Http\Requests;

use App\Enums\ReportStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnalyticsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAnalytics') ?? false;
    }

    public function rules(): array
    {
        $statuses = array_map(
            fn (ReportStatus $status): string => $status->value,
            ReportStatus::cases(),
        );

        return [
            'dataset' => ['sometimes', 'string', Rule::in(['executive', 'kpis', 'comparisons', 'alerts'])],
            'department' => ['sometimes', 'nullable', 'string', 'max:255'],
            'employee' => ['sometimes', 'nullable', 'integer', 'exists:employees,id'],
            'format' => ['sometimes', 'string', Rule::in(['csv', 'xlsx', 'pdf'])],
            'from' => ['required_if:period,custom', 'date'],
            'granularity' => ['sometimes', 'string', Rule::in(['weekly', 'monthly', 'yearly'])],
            'period' => ['sometimes', 'string', Rule::in([
                'today',
                'last_7_days',
                'last_30_days',
                'quarter',
                'year',
                'custom',
            ])],
            'status' => ['sometimes', 'nullable', 'string', Rule::in($statuses)],
            'to' => ['required_if:period,custom', 'date', 'after_or_equal:from'],
        ];
    }
}
