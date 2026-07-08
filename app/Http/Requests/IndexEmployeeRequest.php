<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sorts = [
            'active',
            'created_at',
            'department',
            'email',
            'first_name',
            'last_name',
            'name',
            'reports_count',
            'updated_at',
        ];

        return [
            'active' => ['nullable', Rule::in(['0', '1', 'false', 'true'])],
            'department' => ['nullable', 'string', 'max:255'],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'search' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', Rule::in(array_merge($sorts, array_map(fn (string $sort) => "-{$sort}", $sorts)))],
        ];
    }
}