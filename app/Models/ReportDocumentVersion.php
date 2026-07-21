<?php

namespace App\Models;

use Database\Factories\ReportDocumentVersionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportDocumentVersion extends Model
{
    /** @use HasFactory<ReportDocumentVersionFactory> */
    use HasFactory;

    protected $fillable = [
        'report_document_id',
        'uploaded_by_id',
        'version_number',
        'disk',
        'path',
        'original_filename',
        'mime_type',
        'extension',
        'size',
        'checksum',
        'notes',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(ReportDocument::class, 'report_document_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by_id');
    }
}
