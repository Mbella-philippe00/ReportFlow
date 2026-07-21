<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnterpriseAiSetting extends Model
{
    protected $fillable = ['key', 'provider', 'model', 'enabled', 'fallback_enabled', 'options'];

    protected $casts = [
        'enabled' => 'boolean',
        'fallback_enabled' => 'boolean',
        'options' => 'array',
    ];
}
