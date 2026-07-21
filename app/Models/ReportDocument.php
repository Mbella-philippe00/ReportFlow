<?php

namespace App\Models;

use Database\Factories\ReportDocumentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportDocument extends Model
{
    /** @use HasFactory<ReportDocumentFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'weekly_report_id',
        'uploaded_by_id',
        'current_version_id',
        'title',
        'description',
        'category',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(WeeklyReport::class, 'weekly_report_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by_id');
    }

    public function currentVersion(): BelongsTo
    {
        return $this->belongsTo(ReportDocumentVersion::class, 'current_version_id');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(ReportDocumentVersion::class)->orderByDesc('version_number');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(DocumentComment::class);
    }

    public function rootComments(): HasMany
    {
        return $this->hasMany(DocumentComment::class)
            ->whereNull('parent_id')
            ->oldest();
    }
}
