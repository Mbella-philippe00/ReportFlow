<?php

namespace Database\Factories;

use App\Models\ReportDocument;
use App\Models\ReportDocumentVersion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReportDocumentVersion>
 */
class ReportDocumentVersionFactory extends Factory
{
    protected $model = ReportDocumentVersion::class;

    public function definition(): array
    {
        $filename = fake()->slug(3).'.txt';

        return [
            'report_document_id' => ReportDocument::factory(),
            'uploaded_by_id' => User::factory(),
            'version_number' => 1,
            'disk' => 'public',
            'path' => 'report-documents/demo/'.$filename,
            'original_filename' => $filename,
            'mime_type' => 'text/plain',
            'extension' => 'txt',
            'size' => fake()->numberBetween(900, 5200),
            'checksum' => hash('sha256', $filename),
            'notes' => fake()->optional()->sentence(10),
        ];
    }
}
