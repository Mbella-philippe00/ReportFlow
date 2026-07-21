<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentActivityResource;
use App\Http\Resources\DocumentCommentResource;
use App\Http\Resources\ReportDocumentResource;
use App\Http\Resources\ReportDocumentVersionResource;
use App\Models\DocumentComment;
use App\Models\ReportDocument;
use App\Models\User;
use App\Models\WeeklyReport;
use App\Services\Reports\DocumentCollaborationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportDocumentController extends Controller
{
    public function __construct(private readonly DocumentCollaborationService $documents)
    {
    }

    public function index(Request $request, WeeklyReport $report): JsonResponse
    {
        Gate::authorize('viewAny', [ReportDocument::class, $report]);

        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:120'],
            'category' => ['nullable', 'string', 'max:60'],
            'type' => ['nullable', 'string', 'max:40'],
            'sort' => ['nullable', 'in:latest,oldest,title,size'],
        ]);

        $query = $report->documents()
            ->with(['currentVersion.uploader', 'uploader'])
            ->withCount(['comments', 'versions']);

        if (! empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($query) use ($search): void {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('currentVersion', fn ($versionQuery) => $versionQuery
                        ->where('original_filename', 'like', "%{$search}%"));
            });
        }

        if (! empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (! empty($filters['type'])) {
            $type = $filters['type'];

            $query->whereHas('currentVersion', function ($versionQuery) use ($type): void {
                match ($type) {
                    'image' => $versionQuery->where('mime_type', 'like', 'image/%'),
                    'pdf' => $versionQuery->where('mime_type', 'application/pdf'),
                    'text' => $versionQuery->where('mime_type', 'like', 'text/%'),
                    default => $versionQuery->where('extension', $type),
                };
            });
        }

        match ($filters['sort'] ?? 'latest') {
            'oldest' => $query->oldest(),
            'title' => $query->orderBy('title'),
            'size' => $query->join('report_document_versions as current_versions', 'report_documents.current_version_id', '=', 'current_versions.id')
                ->orderByDesc('current_versions.size')
                ->select('report_documents.*'),
            default => $query->latest(),
        };

        $documents = $query->paginate(12);

        return response()->json([
            'success' => true,
            'data' => ReportDocumentResource::collection($documents),
            'meta' => [
                'current_page' => $documents->currentPage(),
                'last_page' => $documents->lastPage(),
                'per_page' => $documents->perPage(),
                'total' => $documents->total(),
            ],
        ]);
    }

    public function store(Request $request, WeeklyReport $report): JsonResponse
    {
        Gate::authorize('create', [ReportDocument::class, $report]);

        $validated = $request->validate([
            'file' => $this->documentFileRules(),
            'title' => ['nullable', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category' => ['nullable', 'string', 'max:60'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'metadata' => ['nullable', 'array'],
        ]);

        $user = $request->user();
        $file = $validated['file'];

        $document = DB::transaction(function () use ($report, $validated, $user, $file): ReportDocument {
            $document = $report->documents()->create([
                'uploaded_by_id' => $user->id,
                'title' => $validated['title'] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'description' => $validated['description'] ?? null,
                'category' => $validated['category'] ?? 'general',
                'metadata' => $validated['metadata'] ?? [],
            ]);

            $this->documents->storeInitialVersion($document, $file, $user, $validated['notes'] ?? null);

            return $document->fresh(['currentVersion.uploader', 'uploader', 'report.employee.user']);
        });

        $this->logDocument($document, 'document_uploaded', 'Document uploaded', [
            'report_id' => $report->id,
            'title' => $document->title,
            'category' => $document->category,
        ]);

        $this->documents->notifyDocumentParticipants($document, 'uploaded', $user);

        return response()->json([
            'success' => true,
            'message' => 'Document uploaded successfully.',
            'data' => new ReportDocumentResource($document->loadCount(['comments', 'versions'])),
        ], 201);
    }

    public function show(WeeklyReport $report, ReportDocument $document): JsonResponse
    {
        $this->ensureDocumentBelongsToReport($report, $document);
        Gate::authorize('view', $document);

        return response()->json([
            'success' => true,
            'data' => new ReportDocumentResource(
                $document->load(['currentVersion.uploader', 'uploader'])->loadCount(['comments', 'versions'])
            ),
        ]);
    }

    public function update(Request $request, WeeklyReport $report, ReportDocument $document): JsonResponse
    {
        $this->ensureDocumentBelongsToReport($report, $document);
        Gate::authorize('update', $document);

        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category' => ['sometimes', 'required', 'string', 'max:60'],
            'metadata' => ['nullable', 'array'],
        ]);

        $document->update($validated);

        $this->logDocument($document, 'document_updated', 'Document metadata updated', [
            'report_id' => $report->id,
            'title' => $document->title,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Document updated.',
            'data' => new ReportDocumentResource(
                $document->fresh(['currentVersion.uploader', 'uploader'])->loadCount(['comments', 'versions'])
            ),
        ]);
    }

    public function destroy(WeeklyReport $report, ReportDocument $document): JsonResponse
    {
        $this->ensureDocumentBelongsToReport($report, $document);
        Gate::authorize('delete', $document);

        $this->logDocument($document, 'document_deleted', 'Document deleted', [
            'report_id' => $report->id,
            'title' => $document->title,
        ]);

        $document->delete();

        return response()->json([
            'success' => true,
            'message' => 'Document deleted.',
        ]);
    }

    public function download(WeeklyReport $report, ReportDocument $document): StreamedResponse
    {
        $this->ensureDocumentBelongsToReport($report, $document);
        Gate::authorize('download', $document);

        $version = $document->currentVersion;
        abort_if(! $version, 404);

        return Storage::disk($version->disk)->download($version->path, $version->original_filename);
    }

    public function preview(WeeklyReport $report, ReportDocument $document): JsonResponse
    {
        $this->ensureDocumentBelongsToReport($report, $document);
        Gate::authorize('preview', $document);

        $version = $document->currentVersion;
        abort_if(! $version, 404);

        $type = $this->previewType($version->mime_type);
        $payload = [
            'supported' => $type !== 'download',
            'type' => $type,
            'url' => Storage::disk($version->disk)->url($version->path),
            'filename' => $version->original_filename,
            'mime_type' => $version->mime_type,
            'size' => $version->size,
        ];

        if ($type === 'text' && $version->size <= 524288) {
            $payload['content'] = Storage::disk($version->disk)->get($version->path);
        }

        return response()->json([
            'success' => true,
            'data' => $payload,
        ]);
    }

    public function versions(WeeklyReport $report, ReportDocument $document): JsonResponse
    {
        $this->ensureDocumentBelongsToReport($report, $document);
        Gate::authorize('view', $document);

        return response()->json([
            'success' => true,
            'data' => ReportDocumentVersionResource::collection(
                $document->versions()->with('uploader')->get()
            ),
        ]);
    }

    public function storeVersion(Request $request, WeeklyReport $report, ReportDocument $document): JsonResponse
    {
        $this->ensureDocumentBelongsToReport($report, $document);
        Gate::authorize('uploadVersion', $document);

        $validated = $request->validate([
            'file' => $this->documentFileRules(),
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $version = $this->documents->storeNextVersion($document, $validated['file'], $request->user(), $validated['notes'] ?? null);
        $document = $document->fresh(['currentVersion.uploader', 'uploader', 'report.employee.user']);

        $this->logDocument($document, 'document_version_added', 'Document version uploaded', [
            'report_id' => $report->id,
            'title' => $document->title,
            'version_number' => $version->version_number,
        ]);

        $this->documents->notifyDocumentParticipants($document, 'version_added', $request->user());

        return response()->json([
            'success' => true,
            'message' => 'Document version uploaded.',
            'data' => new ReportDocumentResource($document->loadCount(['comments', 'versions'])),
        ], 201);
    }

    public function comments(WeeklyReport $report, ReportDocument $document): JsonResponse
    {
        $this->ensureDocumentBelongsToReport($report, $document);
        Gate::authorize('view', $document);

        return response()->json([
            'success' => true,
            'data' => DocumentCommentResource::collection(
                $document->rootComments()->with(['user', 'replies.user'])->get()
            ),
        ]);
    }

    public function storeComment(Request $request, WeeklyReport $report, ReportDocument $document): JsonResponse
    {
        $this->ensureDocumentBelongsToReport($report, $document);
        Gate::authorize('create', [DocumentComment::class, $document]);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'integer', 'exists:document_comments,id'],
            'mention_ids' => ['nullable', 'array'],
            'mention_ids.*' => ['integer', 'exists:users,id'],
        ]);

        if (! empty($validated['parent_id'])) {
            $parent = DocumentComment::findOrFail($validated['parent_id']);
            $this->ensureCommentBelongsToDocument($document, $parent);
        }

        $mentionIds = $this->resolveMentionIds($validated['body'], $validated['mention_ids'] ?? []);

        $comment = $document->comments()->create([
            'parent_id' => $validated['parent_id'] ?? null,
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
            'mentions' => $mentionIds,
        ]);

        $comment->load(['user', 'document.uploader', 'document.report.employee.user', 'replies.user']);

        $this->logDocument($document, 'document_comment_added', 'Document comment added', [
            'report_id' => $report->id,
            'document_id' => $document->id,
            'comment_id' => $comment->id,
            'parent_id' => $comment->parent_id,
        ]);

        $this->documents->notifyMentions($comment, $mentionIds, $request->user());
        $this->documents->notifyDocumentParticipants($document, 'comment_added', $request->user());

        return response()->json([
            'success' => true,
            'message' => 'Comment added.',
            'data' => new DocumentCommentResource($comment),
        ], 201);
    }

    public function updateComment(Request $request, WeeklyReport $report, ReportDocument $document, DocumentComment $comment): JsonResponse
    {
        $this->ensureDocumentBelongsToReport($report, $document);
        $this->ensureCommentBelongsToDocument($document, $comment);
        Gate::authorize('update', $comment);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
            'mention_ids' => ['nullable', 'array'],
            'mention_ids.*' => ['integer', 'exists:users,id'],
        ]);

        $mentionIds = $this->resolveMentionIds($validated['body'], $validated['mention_ids'] ?? []);

        $comment->update([
            'body' => $validated['body'],
            'mentions' => $mentionIds,
        ]);

        $comment->load(['user', 'replies.user']);

        $this->logDocument($document, 'document_comment_updated', 'Document comment updated', [
            'report_id' => $report->id,
            'document_id' => $document->id,
            'comment_id' => $comment->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated.',
            'data' => new DocumentCommentResource($comment),
        ]);
    }

    public function destroyComment(WeeklyReport $report, ReportDocument $document, DocumentComment $comment): JsonResponse
    {
        $this->ensureDocumentBelongsToReport($report, $document);
        $this->ensureCommentBelongsToDocument($document, $comment);
        Gate::authorize('delete', $comment);

        $this->logDocument($document, 'document_comment_deleted', 'Document comment deleted', [
            'report_id' => $report->id,
            'document_id' => $document->id,
            'comment_id' => $comment->id,
        ]);

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted.',
        ]);
    }

    public function activity(WeeklyReport $report, ReportDocument $document): JsonResponse
    {
        $this->ensureDocumentBelongsToReport($report, $document);
        Gate::authorize('viewActivity', $document);

        $activity = Activity::query()
            ->with('causer')
            ->where('subject_type', ReportDocument::class)
            ->where('subject_id', $document->id)
            ->latest()
            ->limit(30)
            ->get();

        return response()->json([
            'success' => true,
            'data' => DocumentActivityResource::collection($activity),
        ]);
    }

    private function documentFileRules(): array
    {
        return [
            'required',
            File::types((array) config('reportflow.uploads.allowed_extensions', []))->max((int) config('reportflow.uploads.max_file_size_kb', 20480)),
        ];
    }

    private function ensureDocumentBelongsToReport(WeeklyReport $report, ReportDocument $document): void
    {
        abort_unless($document->weekly_report_id === $report->id, 404);
    }

    private function ensureCommentBelongsToDocument(ReportDocument $document, DocumentComment $comment): void
    {
        abort_unless($comment->report_document_id === $document->id, 404);
    }

    /** @param list<int> $explicitMentionIds */
    private function resolveMentionIds(string $body, array $explicitMentionIds): array
    {
        preg_match_all('/@([A-Z0-9._%+\-]+@[A-Z0-9.\-]+\.[A-Z]{2,})/i', $body, $matches);
        $emailMentionIds = empty($matches[1])
            ? []
            : User::query()->whereIn('email', array_unique($matches[1]))->pluck('id')->all();

        return collect([...$explicitMentionIds, ...$emailMentionIds])
            ->filter(fn ($id): bool => is_numeric($id))
            ->map(fn ($id): int => (int) $id)
            ->unique()
            ->values()
            ->all();
    }

    private function previewType(?string $mimeType): string
    {
        return match (true) {
            str_starts_with((string) $mimeType, 'image/') => 'image',
            $mimeType === 'application/pdf' => 'pdf',
            str_starts_with((string) $mimeType, 'text/'),
            in_array($mimeType, ['application/json', 'application/xml'], true) => 'text',
            default => 'download',
        };
    }

    /** @param array<string, mixed> $properties */
    private function logDocument(ReportDocument $document, string $event, string $description, array $properties): void
    {
        activity()
            ->event($event)
            ->performedOn($document)
            ->causedBy(auth()->user())
            ->withProperties($properties)
            ->log($description);
    }
}
