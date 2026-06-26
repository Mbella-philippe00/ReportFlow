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
     * Utilisateur associé.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Rapports hebdomadaires.
     */
    public function weeklyReports(): HasMany
    {
        return $this->hasMany(WeeklyReport::class);
    }

    /**
     * Nom complet.
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Alias de compatibilité.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->full_name;
    }
}