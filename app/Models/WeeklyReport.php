<?php

namespace App\Models;

use App\Enums\ReportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class WeeklyReport extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'employee_id',
        'department',
        'week',
        'objectives',
        'activities',
        'achievements',
        'difficulties',
        'next_actions',
        'executive_summary',
        'pptx_file',
        'status',
        'submitted_at',
        'under_review_at',
        'validated_at',
        'validated_by',
        'approved_at',
        'approved_by',
        'manager_comment',
        'rejected_at',
        'rejected_by',
        'rejection_reason',
        'generated_at',
    ];

    protected $casts = [
        'status' => ReportStatus::class,
        'submitted_at' => 'datetime',
        'under_review_at' => 'datetime',
        'validated_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'generated_at' => 'datetime',
    ];

    protected $with = [
        'employee',
        'validator',
        'approver',
        'rejector',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'status',
                'week',
                'department',
                'submitted_at',
                'under_review_at',
                'validated_at',
                'validated_by',
                'approved_at',
                'approved_by',
                'manager_comment',
                'rejected_at',
                'rejected_by',
                'rejection_reason',
                'generated_at',
                'pptx_file',
            ])
            ->logOnlyDirty();
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ReportDocument::class);
    }

    public function isDraft(): bool
    {
        return $this->status === ReportStatus::DRAFT;
    }

    public function isSubmitted(): bool
    {
        return $this->status === ReportStatus::SUBMITTED;
    }

    public function isUnderReview(): bool
    {
        return $this->status === ReportStatus::UNDER_REVIEW;
    }

    public function isApproved(): bool
    {
        return $this->status === ReportStatus::APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === ReportStatus::REJECTED;
    }

    public function isReadOnly(): bool
    {
        return $this->isApproved() || $this->isSubmitted() || $this->isUnderReview();
    }

    public function isManagerApproved(): bool
    {
        return $this->isUnderReview();
    }

    public function isGenerated(): bool
    {
        return $this->isApproved();
    }
}
