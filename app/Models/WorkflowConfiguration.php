<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkflowConfiguration extends Model
{
    protected $fillable = ['name', 'version', 'stages', 'transitions', 'applies_to', 'active'];

    protected $casts = [
        'active' => 'boolean',
        'stages' => 'array',
        'transitions' => 'array',
        'applies_to' => 'array',
    ];
}
