<?php

namespace App\Http\Requests\AI;

use Illuminate\Foundation\Http\FormRequest;

class AiProviderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAiProviders') ?? false;
    }

    public function rules(): array
    {
        return [];
    }
}
