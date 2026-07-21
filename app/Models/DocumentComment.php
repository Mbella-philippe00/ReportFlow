<?php

namespace App\Models;

use Database\Factories\DocumentCommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentComment extends Model
{
    /** @use HasFactory<DocumentCommentFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'report_document_id',
        'parent_id',
        'user_id',
        'body',
        'mentions',
    ];

    protected $casts = [
        'mentions' => 'array',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(ReportDocument::class, 'report_document_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->oldest();
    }
}
