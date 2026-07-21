<?php

namespace App\Http\Resources\AI;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AiProviderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource['name'],
            'label' => $this->resource['label'],
            'configured' => $this->resource['configured'],
            'active' => $this->resource['active'] ?? false,
            'models' => $this->resource['models'],
            'default_model' => $this->resource['default_model'],
        ];
    }
}