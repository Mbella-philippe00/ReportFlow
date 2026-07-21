<?php

namespace App\Http\Requests\AI;

use App\Services\AI\AiPromptCatalog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AiHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAiHistory') ?? false;
    }

    public function rules(): array
    {
        return [
            'action' => ['sometimes', 'nullable', 'string', Rule::in(AiPromptCatalog::ALL_ACTIONS)],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'report_id' => ['sometimes', 'nullable', 'integer', 'exists:weekly_reports,id'],
            'scope' => ['sometimes', 'string', Rule::in(['mine', 'all'])],
        ];
    }
}
