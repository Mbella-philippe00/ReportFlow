<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportingCalendar extends Model
{
    protected $fillable = ['name', 'frequency', 'reporting_day', 'due_day', 'reminder_days', 'starts_at', 'ends_at', 'active', 'metadata'];

    protected $casts = [
        'active' => 'boolean',
        'reminder_days' => 'array',
        'starts_at' => 'date',
        'ends_at' => 'date',
        'metadata' => 'array',
    ];
}
