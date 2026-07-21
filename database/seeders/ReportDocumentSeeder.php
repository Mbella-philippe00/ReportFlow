<?php

namespace Database\Seeders;

use App\Models\DocumentComment;
use App\Models\ReportDocument;
use App\Models\User;
use App\Models\WeeklyReport;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ReportDocumentSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('report-documents/demo');

        $users = User::query()->get();
        $reports = WeeklyReport::query()
            ->with('employee.user')
            ->whereNotNull('submitted_at')
            ->latest('submitted_at')
            ->take(45)
            ->get();

        if ($users->isEmpty() || $reports->isEmpty()) {
            return;
        }

        $reports->each(function (WeeklyReport $report, int $index) use ($users): void {
            $documentTotal = fake()->numberBetween(1, 3);

            for ($documentIndex = 1; $documentIndex <= $documentTotal; $documentIndex++) {
                $uploader = $report->employee?->user ?? $users->random();
                $createdAt = CarbonImmutable::instance($report->submitted_at ?? $report->created_at)
                    ->addHours(fake()->numberBetween(1, 28));
                $filename = sprintf('report-%03d-%d-notes.txt', $report->id, $documentIndex);
                $path = "report-documents/demo/{$filename}";
                $content = $this->documentContent($report, $documentIndex);

                Storage::disk('public')->put($path, $content);

                $document = ReportDocument::factory()
                    ->for($report, 'report')
                    ->for($uploader, 'uploader')
                    ->create([
                        'title' => $this->documentTitle($documentIndex),
                        'category' => fake()->randomElement(['metrics', 'evidence', 'planning', 'review']),
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);

                $version = $document->versions()->create([
                    'uploaded_by_id' => $uploader->id,
                    'version_number' => 1,
                    'disk' => 'public',
                    'path' => $path,
                    'original_filename' => $filename,
                    'mime_type' => 'text/plain',
                    'extension' => 'txt',
                    'size' => strlen($content),
                    'checksum' => hash('sha256', $content),
                    'notes' => 'Initial supporting document for weekly review.',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $document->forceFill([
                    'current_version_id' => $version->id,
                    'updated_at' => $createdAt,
                ])->save();

                if ($index % 3 === 0) {
                    $this->addVersion($document, $users->random(), $createdAt->addHours(fake()->numberBetween(4, 24)));
                }

                $this->addComments($document, $users, $createdAt->addHours(fake()->numberBetween(2, 30)));
                $this->logDocument($document, $uploader, 'document_uploaded', 'Document uploaded', $createdAt);
            }
        });
    }

    private function addVersion(ReportDocument $document, User $uploader, CarbonImmutable $createdAt): void
    {
        $filename = sprintf('report-%03d-v2-%s.txt', $document->weekly_report_id, fake()->slug(2));
        $path = "report-documents/demo/{$filename}";
        $content = "Updated collaboration notes for {$document->title}.\n\n".fake()->paragraph();

        Storage::disk('public')->put($path, $content);

        $version = $document->versions()->create([
            'uploaded_by_id' => $uploader->id,
            'version_number' => 2,
            'disk' => 'public',
            'path' => $path,
            'original_filename' => $filename,
            'mime_type' => 'text/plain',
            'extension' => 'txt',
            'size' => strlen($content),
            'checksum' => hash('sha256', $content),
            'notes' => 'Updated after manager feedback.',
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);

        $document->forceFill([
            'current_version_id' => $version->id,
            'updated_at' => $createdAt,
        ])->save();

        $this->logDocument($document, $uploader, 'document_version_added', 'Document version uploaded', $createdAt);
    }

    private function addComments(ReportDocument $document, $users, CarbonImmutable $createdAt): void
    {
        $author = $users->random();
        $mentioned = $users->where('id', '!==', $author->id)->random();

        $comment = DocumentComment::factory()
            ->for($document, 'document')
            ->for($author, 'user')
            ->create([
                'body' => "Looks good. @{$mentioned->email} please confirm the final metric source.",
                'mentions' => [$mentioned->id],
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

        if (fake()->boolean(55)) {
            DocumentComment::factory()
                ->for($document, 'document')
                ->for($mentioned, 'user')
                ->create([
                    'parent_id' => $comment->id,
                    'body' => 'Confirmed. The source is aligned with the latest weekly dashboard.',
                    'mentions' => [],
                    'created_at' => $createdAt->addHours(fake()->numberBetween(1, 8)),
                    'updated_at' => $createdAt->addHours(fake()->numberBetween(1, 8)),
                ]);
        }

        $this->logDocument($document, $author, 'document_comment_added', 'Document comment added', $createdAt);
    }

    private function documentTitle(int $documentIndex): string
    {
        return match ($documentIndex) {
            1 => 'Weekly evidence pack',
            2 => 'Metrics and blockers snapshot',
            default => 'Manager review appendix',
        };
    }

    private function documentContent(WeeklyReport $report, int $documentIndex): string
    {
        return implode("\n\n", [
            "ReportFlow demo attachment #{$documentIndex}",
            "Report: {$report->department} {$report->week}",
            "Objective evidence: {$report->objectives}",
            "Key achievement: {$report->achievements}",
            "Follow-up: {$report->next_actions}",
        ]);
    }

    private function logDocument(ReportDocument $document, User $causer, string $event, string $description, CarbonImmutable $createdAt): void
    {
        $activity = activity()
            ->event($event)
            ->performedOn($document)
            ->causedBy($causer)
            ->withProperties([
                'report_id' => $document->weekly_report_id,
                'document_id' => $document->id,
                'title' => $document->title,
            ])
            ->log($description);

        if (! $activity) {
            return;
        }

        $activity->forceFill([
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ])->save();
    }
}
