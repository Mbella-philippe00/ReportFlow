<?php

namespace Tests\Feature\Documents;

use App\Models\ReportDocument;
use App\Models\ReportDocumentVersion;
use App\Notifications\DocumentMentionNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReportDocumentApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_report_owner_can_upload_search_and_list_documents(): void
    {
        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createSubmittedReport($employee);

        Sanctum::actingAs($user);

        $response = $this->postJson("/api/reports/{$report->id}/documents", [
            'file' => UploadedFile::fake()->createWithContent('evidence.txt', 'Quarterly evidence and metric notes.'),
            'title' => 'Quarterly evidence pack',
            'category' => 'evidence',
            'description' => 'Supporting notes for manager review.',
        ]);

        $response
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'data' => [
                    'title' => 'Quarterly evidence pack',
                    'category' => 'evidence',
                ],
            ]);

        $document = ReportDocument::query()->firstOrFail();
        $version = ReportDocumentVersion::query()->firstOrFail();

        Storage::disk('public')->assertExists($version->path);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => ReportDocument::class,
            'subject_id' => $document->id,
            'event' => 'document_uploaded',
        ]);

        $this->getJson("/api/reports/{$report->id}/documents?search=Quarterly")
            ->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.title', 'Quarterly evidence pack');
    }

    public function test_employee_cannot_access_documents_for_another_employee_report(): void
    {
        $user = $this->createEmployeeUser();
        $otherEmployee = $this->createEmployee();
        $report = $this->createSubmittedReport($otherEmployee);

        Sanctum::actingAs($user);

        $this->getJson("/api/reports/{$report->id}/documents")
            ->assertForbidden();
    }

    public function test_user_can_upload_a_new_document_version(): void
    {
        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createSubmittedReport($employee);

        Sanctum::actingAs($user);

        $documentId = $this->uploadDocument($report->id, 'metrics.txt')->json('data.id');

        $response = $this->postJson("/api/reports/{$report->id}/documents/{$documentId}/versions", [
            'file' => UploadedFile::fake()->createWithContent('metrics-v2.txt', 'Updated metric notes.'),
            'notes' => 'Updated after manager review.',
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('data.versions_count', 2)
            ->assertJsonPath('data.current_version.version_number', 2)
            ->assertJsonPath('data.current_version.original_filename', 'metrics-v2.txt');
    }

    public function test_document_preview_returns_text_content(): void
    {
        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createSubmittedReport($employee);

        Sanctum::actingAs($user);

        $documentId = $this->uploadDocument($report->id, 'preview.txt', 'Previewable text content.')->json('data.id');

        $this->getJson("/api/reports/{$report->id}/documents/{$documentId}/preview")
            ->assertOk()
            ->assertJsonPath('data.supported', true)
            ->assertJsonPath('data.type', 'text')
            ->assertJsonPath('data.content', 'Previewable text content.');
    }

    public function test_threaded_comment_mentions_notify_users(): void
    {
        Notification::fake();

        $manager = $this->createManager();
        $mentioned = $this->createEmployeeUser();
        $owner = $this->createEmployeeUser();
        $employee = $this->createEmployee($owner);
        $report = $this->createSubmittedReport($employee);

        Sanctum::actingAs($owner);

        $documentId = $this->uploadDocument($report->id, 'collaboration.txt')->json('data.id');

        Sanctum::actingAs($manager);

        $comment = $this->postJson("/api/reports/{$report->id}/documents/{$documentId}/comments", [
            'body' => "Please verify this attachment @{$mentioned->email}.",
            'mention_ids' => [$mentioned->id],
        ]);

        $comment
            ->assertCreated()
            ->assertJsonPath('data.mentions.0', $mentioned->id);

        $reply = $this->postJson("/api/reports/{$report->id}/documents/{$documentId}/comments", [
            'body' => 'Confirmed and ready for review.',
            'parent_id' => $comment->json('data.id'),
        ]);

        $reply
            ->assertCreated()
            ->assertJsonPath('data.parent_id', $comment->json('data.id'));

        Notification::assertSentTo($mentioned, DocumentMentionNotification::class);

        $this->getJson("/api/reports/{$report->id}/documents/{$documentId}/comments")
            ->assertOk()
            ->assertJsonPath('data.0.replies.0.body', 'Confirmed and ready for review.');
    }

    public function test_document_can_be_soft_deleted_by_owner(): void
    {
        $user = $this->createEmployeeUser();
        $employee = $this->createEmployee($user);
        $report = $this->createSubmittedReport($employee);

        Sanctum::actingAs($user);

        $documentId = $this->uploadDocument($report->id, 'obsolete.txt')->json('data.id');

        $this->deleteJson("/api/reports/{$report->id}/documents/{$documentId}")
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        $this->assertSoftDeleted('report_documents', [
            'id' => $documentId,
        ]);
    }

    private function uploadDocument(int $reportId, string $filename, string $content = 'Document notes.'): \Illuminate\Testing\TestResponse
    {
        return $this->postJson("/api/reports/{$reportId}/documents", [
            'file' => UploadedFile::fake()->createWithContent($filename, $content),
            'title' => pathinfo($filename, PATHINFO_FILENAME),
            'category' => 'evidence',
        ]);
    }
}
