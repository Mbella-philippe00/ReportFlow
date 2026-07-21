<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnterpriseTeam extends Model
{
    protected $fillable = ['department_id', 'name', 'code', 'description', 'lead_id', 'active', 'metadata'];

    protected $casts = [
        'active' => 'boolean',
        'metadata' => 'array',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(EnterpriseDepartment::class, 'department_id');
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lead_id');
    }
}
