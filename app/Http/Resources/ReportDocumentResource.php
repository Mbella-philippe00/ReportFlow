<?php

namespace App\Http\Resources;

use App\Models\ReportDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin ReportDocument
 */
class ReportDocumentResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        $version = $this->currentVersion;
        $preview = $version ? $this->previewMetadata($version->mime_type, $version->disk, $version->path) : null;

        return [
            'id' => $this->id,
            'report_id' => $this->weekly_report_id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'metadata' => $this->metadata ?? [],
            'uploaded_by' => [
                'id' => $this->uploader?->id,
                'name' => $this->uploader?->name,
                'email' => $this->uploader?->email,
            ],
            'current_version' => $version ? new ReportDocumentVersionResource($version) : null,
            'versions_count' => $this->versions_count ?? $this->versions()->count(),
            'comments_count' => $this->comments_count ?? $this->comments()->count(),
            'preview' => $preview,
            'download_url' => "/api/reports/{$this->weekly_report_id}/documents/{$this->id}/download",
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /** @return array<string, mixed> */
    private function previewMetadata(?string $mimeType, string $disk, string $path): array
    {
        $type = match (true) {
            str_starts_with((string) $mimeType, 'image/') => 'image',
            $mimeType === 'application/pdf' => 'pdf',
            str_starts_with((string) $mimeType, 'text/'),
            in_array($mimeType, ['application/json', 'application/xml'], true) => 'text',
            default => 'download',
        };

        return [
            'supported' => $type !== 'download',
            'type' => $type,
            'url' => Storage::disk($disk)->url($path),
        ];
    }
}
