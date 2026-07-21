<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureFlag extends Model
{
    protected $fillable = ['key', 'name', 'description', 'enabled', 'scope', 'rollout_percentage', 'metadata'];

    protected $casts = [
        'enabled' => 'boolean',
        'metadata' => 'array',
    ];
}
