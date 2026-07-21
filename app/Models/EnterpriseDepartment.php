<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EnterpriseDepartment extends Model
{
    protected $fillable = ['name', 'code', 'description', 'manager_id', 'active', 'metadata'];

    protected $casts = [
        'active' => 'boolean',
        'metadata' => 'array',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function teams(): HasMany
    {
        return $this->hasMany(EnterpriseTeam::class, 'department_id');
    }

    public function positions(): HasMany
    {
        return $this->hasMany(EnterprisePosition::class, 'department_id');
    }
}
