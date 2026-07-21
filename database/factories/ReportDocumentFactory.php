<?php

namespace Database\Factories;

use App\Models\ReportDocument;
use App\Models\User;
use App\Models\WeeklyReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReportDocument>
 */
class ReportDocumentFactory extends Factory
{
    protected $model = ReportDocument::class;

    public function definition(): array
    {
        return [
            'weekly_report_id' => WeeklyReport::factory(),
            'uploaded_by_id' => User::factory(),
            'title' => fake()->randomElement([
                'Supporting metrics snapshot',
                'Client feedback summary',
                'Risk follow-up notes',
                'Weekly evidence pack',
                'Action plan appendix',
            ]),
            'description' => fake()->sentence(12),
            'category' => fake()->randomElement(['metrics', 'evidence', 'planning', 'review', 'general']),
            'metadata' => [
                'source' => fake()->randomElement(['dashboard export', 'team note', 'meeting recap', 'manual upload']),
                'confidentiality' => fake()->randomElement(['internal', 'manager-review', 'team']),
            ],
        ];
    }
}
