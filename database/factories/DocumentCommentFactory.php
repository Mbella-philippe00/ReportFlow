<?php

namespace Database\Factories;

use App\Models\DocumentComment;
use App\Models\ReportDocument;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DocumentComment>
 */
class DocumentCommentFactory extends Factory
{
    protected $model = DocumentComment::class;

    public function definition(): array
    {
        return [
            'report_document_id' => ReportDocument::factory(),
            'parent_id' => null,
            'user_id' => User::factory(),
            'body' => fake()->randomElement([
                'This evidence is useful for the manager review.',
                'Can we add the source date before final approval?',
                'I checked the numbers and they align with the report.',
                'Please keep this version attached for audit context.',
            ]),
            'mentions' => [],
        ];
    }
}
