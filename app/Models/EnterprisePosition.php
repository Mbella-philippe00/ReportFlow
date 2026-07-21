<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnterprisePosition extends Model
{
    protected $fillable = ['department_id', 'title', 'code', 'level', 'description', 'active', 'metadata'];

    protected $casts = [
        'active' => 'boolean',
        'metadata' => 'array',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(EnterpriseDepartment::class, 'department_id');
    }
}
