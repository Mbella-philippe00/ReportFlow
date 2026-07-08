<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'direction' => ['sometimes', 'string', Rule::in(['asc', 'desc'])],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'search' => ['sometimes', 'nullable', 'string', 'max:255'],
            'sort' => ['sometimes', 'string', Rule::in([
                'created_at',
                'read_at',
                'type',
                '-created_at',
                '-read_at',
                '-type',
            ])],
            'status' => ['sometimes', 'string', Rule::in([
                'all',
                'archived',
                'read',
                'unread',
            ])],
            'type' => ['sometimes', 'string', Rule::in([
                'administration',
                'ai',
                'employees',
                'reports',
                'system',
                'workflow',
            ])],
        ];
    }
}
