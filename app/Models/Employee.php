<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'department',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Utilisateur associé à l'employé.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function getFullNameAttribute(): string
{
    return trim($this->first_name . ' ' . $this->last_name);
}

    /**
     * Rapports hebdomadaires de l'employé.
     */
    public function weeklyReports(): HasMany
    {
        return $this->hasMany(WeeklyReport::class);
    }

    

    /**
     * Nom affiché.
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}