<?php

namespace Database\Factories;

use App\Enums\ReportStatus;
use App\Models\Employee;
use App\Models\WeeklyReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WeeklyReport>
 */
class WeeklyReportFactory extends Factory
{
    protected $model = WeeklyReport::class;

    public function definition(): array
    {
        return [

            'employee_id' => Employee::factory(),

            'department' => fake()->randomElement([
                'IT',
                'RH',
                'Finance',
                'Production',
                'Qualité',
            ]),

            'week' => now()->format('Y-\WW'),

            'objectives' => fake()->paragraph(),

            'activities' => fake()->paragraph(),

            'achievements' => fake()->paragraph(),

            'difficulties' => fake()->sentence(),

            'next_actions' => fake()->paragraph(),

            'executive_summary' => fake()->paragraph(),

            'status' => ReportStatus::DRAFT,
        ];
    }

    public function draft(): static
    {
        return $this->state([
            'status' => ReportStatus::DRAFT,
        ]);
    }

    public function submitted(): static
    {
        return $this->state([
            'status' => ReportStatus::SUBMITTED,
            'submitted_at' => now(),
        ]);
    }

    public function managerApproved(): static
    {
        return $this->state([
            'status' => ReportStatus::MANAGER_APPROVED,
            'submitted_at' => now(),
            'validated_at' => now(),
        ]);
    }

    public function generated(): static
    {
        return $this->state([
            'status' => ReportStatus::GENERATED,
            'submitted_at' => now(),
            'validated_at' => now(),
            'generated_at' => now(),
            'pptx_file' => 'reports/demo.pptx',
        ]);
    }

    public function rejected(): static
    {
        return $this->state([
            'status' => ReportStatus::REJECTED,
            'submitted_at' => now(),
            'rejected_at' => now(),
            'rejection_reason' => fake()->sentence(),
        ]);
    }

    public function withoutSummary(): static
    {
        return $this->state([
            'executive_summary' => null,
        ]);
    }
}
