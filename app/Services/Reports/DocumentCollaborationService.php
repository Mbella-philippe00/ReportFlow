<?php

namespace App\Services\Reports;

use App\Models\DocumentComment;
use App\Models\ReportDocument;
use App\Models\ReportDocumentVersion;
use App\Models\User;
use App\Notifications\DocumentMentionNotification;
use App\Notifications\ReportDocumentUpdatedNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DocumentCollaborationService
{
    public function storeInitialVersion(
        ReportDocument $document,
        UploadedFile $file,
        User $actor,
        ?string $notes = null,
    ): ReportDocumentVersion {
        return $this->storeVersion($document, $file, $actor, 1, $notes);
    }

    public function storeNextVersion(
        ReportDocument $document,
        UploadedFile $file,
        User $actor,
        ?string $notes = null,
    ): ReportDocumentVersion {
        $nextVersion = ((int) $document->versions()->max('version_number')) + 1;

        return $this->storeVersion($document, $file, $actor, $nextVersion, $notes);
    }

    public function notifyDocumentParticipants(ReportDocument $document, string $event, User $actor): void
    {
        collect([
            $document->report->employee?->user,
            $document->uploader,
        ])
            ->filter()
            ->reject(fn (User $user): bool => $user->id === $actor->id)
            ->unique('id')
            ->each(fn (User $user): mixed => $user->notify(
                new ReportDocumentUpdatedNotification($document, $event, $actor)
            ));
    }

    /** @param list<int> $mentionIds */
    public function notifyMentions(DocumentComment $comment, array $mentionIds, User $actor): void
    {
        $this->mentionRecipients($mentionIds, $actor)
            ->each(fn (User $user): mixed => $user->notify(new DocumentMentionNotification($comment)));
    }

    /** @return Collection<int, User> */
    public function mentionRecipients(array $mentionIds, User $actor): Collection
    {
        return User::query()
            ->whereIn('id', array_unique($mentionIds))
            ->get()
            ->reject(fn (User $user): bool => $user->id === $actor->id)
            ->values();
    }

    private function storeVersion(
        ReportDocument $document,
        UploadedFile $file,
        User $actor,
        int $versionNumber,
        ?string $notes = null,
    ): ReportDocumentVersion {
        $path = $file->store("report-documents/{$document->weekly_report_id}/{$document->id}", 'public');

        return DB::transaction(function () use ($document, $file, $actor, $versionNumber, $notes, $path): ReportDocumentVersion {
            $version = $document->versions()->create([
                'uploaded_by_id' => $actor->id,
                'version_number' => $versionNumber,
                'disk' => 'public',
                'path' => $path,
                'original_filename' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'extension' => strtolower((string) $file->getClientOriginalExtension()),
                'size' => $file->getSize() ?: 0,
                'checksum' => hash_file('sha256', $file->getRealPath()),
                'notes' => $notes,
            ]);

            $document->forceFill(['current_version_id' => $version->id])->save();

            return $version;
        });
    }
}
