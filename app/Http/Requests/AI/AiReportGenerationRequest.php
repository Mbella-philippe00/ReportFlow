<?php

namespace App\Http\Requests\AI;

use App\Services\AI\AiPromptCatalog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AiReportGenerationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'action' => ['sometimes', 'string', Rule::in(AiPromptCatalog::ALL_ACTIONS)],
            'instructions' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'locale' => ['sometimes', 'string', Rule::in(['en', 'fr'])],
            'persist' => ['sometimes', 'boolean'],
            'section' => ['sometimes', 'nullable', 'string', Rule::in([
                'objectives',
                'activities',
                'achievements',
                'difficulties',
                'next_actions',
                'executive_summary',
            ])],
            'text' => ['sometimes', 'nullable', 'string', 'max:12000'],
        ];
    }
}
