<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = ['key', 'group', 'label', 'type', 'value', 'is_public'];

    protected $casts = [
        'value' => 'array',
        'is_public' => 'boolean',
    ];
}
