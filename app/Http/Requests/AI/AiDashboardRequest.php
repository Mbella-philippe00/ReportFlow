<?php

namespace App\Http\Requests\AI;

use Illuminate\Foundation\Http\FormRequest;

class AiDashboardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAiDashboard') ?? false;
    }

    public function rules(): array
    {
        return [];
    }
}
