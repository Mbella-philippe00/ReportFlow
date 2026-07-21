<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnterpriseNotificationSetting extends Model
{
    protected $fillable = ['key', 'label', 'enabled', 'channels', 'frequency', 'recipients', 'metadata'];

    protected $casts = [
        'enabled' => 'boolean',
        'channels' => 'array',
        'recipients' => 'array',
        'metadata' => 'array',
    ];
}
