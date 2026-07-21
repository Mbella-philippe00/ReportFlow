<?php

namespace App\Services\Analytics;

use App\Enums\ReportStatus;
use App\Models\Employee;
use App\Models\WeeklyReport;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;

class AnalyticsService
{
    public function overview(array $filters): array
    {
        $query = $this->filteredReportsQuery($filters);
        $statusCounts = $this->statusCounts($query);

        $totalReports = array_sum($statusCounts);
        $submittedReports = $statusCounts[ReportStatus::SUBMITTED->value];
        $managerApprovedReports = $statusCounts[ReportStatus::UNDER_REVIEW->value];
        $generatedReports = $statusCounts[ReportStatus::APPROVED->value];
        $rejectedReports = $statusCounts[ReportStatus::REJECTED->value];
        $draftReports = $statusCounts[ReportStatus::DRAFT->value];
        $decidedReports = $generatedReports + $rejectedReports;
        $activeWorkflowReports = $submittedReports + $managerApprovedReports;

        return [
            'total_reports' => $totalReports,
            'submitted_reports' => $submittedReports,
            'approved_reports' => $managerApprovedReports + $generatedReports,
            'rejected_reports' => $rejectedReports,
            'generated_reports' => $generatedReports,
            'pending_reports' => $activeWorkflowReports,
            'validation_rate' => $this->percentage($generatedReports, $decidedReports),
            'completion_rate' => $this->percentage($totalReports - $draftReports, $totalReports),
            'average_approval_time' => $this->averageApprovalTime($query),
            'status_distribution' => $this->formatStatusDistribution($statusCounts),
        ];
    }

    public function trends(array $filters): array
    {
        $granularity = $filters['granularity'] ?? 'weekly';
        $reports = $this->filteredReportsQuery($filters)
            ->orderBy('created_at')
            ->get();

        $series = $reports
            ->groupBy(fn (WeeklyReport $report): string => $this->trendKey($report, $granularity))
            ->sortKeys()
            ->map(function (Collection $reports, string $period) use ($granularity): array {
                return [
                    'period' => $period,
                    'label' => $this->trendLabel($period, $granularity),
                    'total_reports' => $reports->count(),
                    'submitted_reports' => $this->collectionStatusCount($reports, ReportStatus::SUBMITTED),
                    'approved_reports' => $this->collectionStatusCount($reports, ReportStatus::UNDER_REVIEW)
                        + $this->collectionStatusCount($reports, ReportStatus::APPROVED),
                    'generated_reports' => $this->collectionStatusCount($reports, ReportStatus::APPROVED),
                    'rejected_reports' => $this->collectionStatusCount($reports, ReportStatus::REJECTED),
                    'pending_reports' => $this->collectionStatusCount($reports, ReportStatus::SUBMITTED)
                        + $this->collectionStatusCount($reports, ReportStatus::UNDER_REVIEW),
                ];
            })
            ->values()
            ->all();

        return [
            'type' => 'trends',
            'data' => $series,
            'meta' => [
                'granularity' => $granularity,
            ],
        ];
    }

    public function reports(array $filters): array
    {
        $query = $this->filteredReportsQuery($filters);
        $totalReports = (clone $query)->count();
        $generatedReports = (clone $query)
            ->where('status', ReportStatus::APPROVED)
            ->count();
        $reportsWithPowerPoint = (clone $query)
            ->whereNotNull('pptx_file')
            ->count();

        return [
            'type' => 'reports',
            'data' => [
                'status_distribution' => $this->formatStatusDistribution(
                    $this->statusCounts($query),
                ),
                'department_distribution' => $this->columnDistribution($query, 'department'),
                'weekly_distribution' => $this->columnDistribution($query, 'week'),
                'generated_powerpoint_statistics' => [
                    'generated_reports' => $generatedReports,
                    'reports_with_powerpoint' => $reportsWithPowerPoint,
                    'generation_rate' => $this->percentage($reportsWithPowerPoint, $totalReports),
                ],
            ],
            'meta' => [
                'total_reports' => $totalReports,
            ],
        ];
    }

    public function employees(array $filters): array
    {
        $reports = $this->filteredReportsQuery($filters)
            ->with('employee')
            ->get()
            ->filter(fn (WeeklyReport $report): bool => $report->employee !== null);

        $employees = $reports
            ->groupBy('employee_id')
            ->map(function (Collection $reports): array {
                $employee = $reports->first()->employee;
                $generatedReports = $this->collectionStatusCount($reports, ReportStatus::APPROVED);
                $rejectedReports = $this->collectionStatusCount($reports, ReportStatus::REJECTED);
                $decidedReports = $generatedReports + $rejectedReports;

                return [
                    'employee' => [
                        'id' => $employee->id,
                        'name' => $employee->full_name,
                        'email' => $employee->email,
                        'department' => $employee->department,
                        'active' => $employee->active,
                    ],
                    'total_reports' => $reports->count(),
                    'reports_submitted' => $reports->filter(
                        fn (WeeklyReport $report): bool => $report->submitted_at !== null,
                    )->count(),
                    'approval_rate' => $this->percentage($generatedReports, $decidedReports),
                    'average_completion_time' => $this->averageCompletionTime($reports),
                    'generated_reports' => $generatedReports,
                ];
            })
            ->sortByDesc('total_reports')
            ->values()
            ->all();

        return [
            'type' => 'employees',
            'data' => $employees,
            'meta' => [
                'total_employees' => count($employees),
            ],
        ];
    }

    public function departments(array $filters): array
    {
        $reports = $this->filteredReportsQuery($filters)
            ->get();

        $departments = $reports
            ->groupBy(fn (WeeklyReport $report): string => $report->department ?: 'Unassigned')
            ->map(function (Collection $reports, string $department): array {
                $generatedReports = $this->collectionStatusCount($reports, ReportStatus::APPROVED);
                $rejectedReports = $this->collectionStatusCount($reports, ReportStatus::REJECTED);
                $draftReports = $this->collectionStatusCount($reports, ReportStatus::DRAFT);
                $decidedReports = $generatedReports + $rejectedReports;
                $pendingReports = $this->collectionStatusCount($reports, ReportStatus::SUBMITTED)
                    + $this->collectionStatusCount($reports, ReportStatus::UNDER_REVIEW);

                return [
                    'department' => $department,
                    'active_employees' => Employee::query()
                        ->where('department', $department === 'Unassigned' ? null : $department)
                        ->where('active', true)
                        ->count(),
                    'total_reports' => $reports->count(),
                    'generated_reports' => $generatedReports,
                    'rejected_reports' => $rejectedReports,
                    'pending_reports' => $pendingReports,
                    'validation_rate' => $this->percentage($generatedReports, $decidedReports),
                    'completion_rate' => $this->percentage($reports->count() - $draftReports, $reports->count()),
                ];
            })
            ->sortByDesc('total_reports')
            ->values()
            ->all();

        return [
            'type' => 'departments',
            'data' => $departments,
            'meta' => [
                'total_departments' => count($departments),
            ],
        ];
    }

    public function workflow(array $filters): array
    {
        $query = $this->filteredReportsQuery($filters);
        $statusCounts = $this->statusCounts($query);

        return [
            'type' => 'workflow',
            'data' => [
                'current_distribution' => $this->formatStatusDistribution($statusCounts),
                'approval_bottlenecks' => [
                    $this->bottleneckSummary($query, ReportStatus::SUBMITTED, 'submitted_at', 'manager_approval'),
                    $this->bottleneckSummary($query, ReportStatus::UNDER_REVIEW, 'validated_at', 'final_approval'),
                ],
                'average_processing_time' => $this->averageApprovalTime($query),
                'transition_rates' => [
                    'submission_rate' => $this->percentage(
                        $statusCounts[ReportStatus::SUBMITTED->value]
                            + $statusCounts[ReportStatus::UNDER_REVIEW->value]
                            + $statusCounts[ReportStatus::APPROVED->value]
                            + $statusCounts[ReportStatus::REJECTED->value],
                        array_sum($statusCounts),
                    ),
                    'manager_approval_rate' => $this->percentage(
                        $statusCounts[ReportStatus::UNDER_REVIEW->value]
                            + $statusCounts[ReportStatus::APPROVED->value],
                        $statusCounts[ReportStatus::SUBMITTED->value]
                            + $statusCounts[ReportStatus::UNDER_REVIEW->value]
                            + $statusCounts[ReportStatus::APPROVED->value]
                            + $statusCounts[ReportStatus::REJECTED->value],
                    ),
                    'final_approval_rate' => $this->percentage(
                        $statusCounts[ReportStatus::APPROVED->value],
                        $statusCounts[ReportStatus::UNDER_REVIEW->value]
                            + $statusCounts[ReportStatus::APPROVED->value],
                    ),
                    'rejection_rate' => $this->percentage(
                        $statusCounts[ReportStatus::REJECTED->value],
                        $statusCounts[ReportStatus::APPROVED->value]
                            + $statusCounts[ReportStatus::REJECTED->value],
                    ),
                ],
            ],
            'meta' => [
                'total_reports' => array_sum($statusCounts),
            ],
        ];
    }

    public function activity(array $filters): array
    {
        [$from, $to] = $this->dateRange($filters);
        $reportIds = $this->filteredReportsQuery($filters)->pluck('id');

        if ($reportIds->isEmpty()) {
            return [
                'type' => 'activity',
                'data' => [],
                'meta' => [
                    'total_activity' => 0,
                ],
            ];
        }

        $activities = Activity::query()
            ->with('causer')
            ->where('subject_type', WeeklyReport::class)
            ->whereIn('subject_id', $reportIds)
            ->whereBetween('created_at', [$from, $to])
            ->where(function (Builder $query): void {
                $query
                    ->where('description', 'like', 'Rapport soumis')
                    ->orWhere('description', 'like', 'Rapport%valid%')
                    ->orWhere('description', 'like', 'Rapport%rejet%');
            })
            ->latest()
            ->take(20)
            ->get()
            ->map(fn (Activity $activity): array => [
                'id' => $activity->id,
                'description' => $activity->description,
                'event' => $activity->event,
                'type' => $this->activityType($activity->description),
                'report_id' => $activity->subject_id,
                'causer' => $activity->causer ? [
                    'id' => $activity->causer->getKey(),
                    'name' => $activity->causer->name,
                    'email' => $activity->causer->email,
                ] : null,
                'properties' => $activity->properties,
                'occurred_at' => $activity->created_at,
            ])
            ->values();

        return [
            'type' => 'activity',
            'data' => $activities->all(),
            'meta' => [
                'total_activity' => $activities->count(),
            ],
        ];
    }

    public function exportOptions(): array
    {
        return [
            'supported' => false,
            'available_formats' => [],
            'message' => 'Dedicated analytics exports are not available yet.',
            'future_formats' => ['csv', 'xlsx', 'pdf'],
        ];
    }

    public function filterSummary(array $filters): array
    {
        [$from, $to] = $this->dateRange($filters);

        return [
            'period' => $filters['period'] ?? 'last_30_days',
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'department' => $filters['department'] ?? null,
            'employee' => $filters['employee'] ?? null,
            'status' => $filters['status'] ?? null,
        ];
    }

    private function filteredReportsQuery(array $filters): Builder
    {
        [$from, $to] = $this->dateRange($filters);

        $query = WeeklyReport::query()
            ->with('employee')
            ->whereBetween('created_at', [$from, $to]);

        if (! blank($filters['department'] ?? null)) {
            $query->where('department', trim((string) $filters['department']));
        }

        if (! blank($filters['employee'] ?? null)) {
            $query->where('employee_id', (int) $filters['employee']);
        }

        if (! blank($filters['status'] ?? null)) {
            $query->where('status', (string) $filters['status']);
        }

        return $query;
    }

    /**
     * @return array{0: CarbonImmutable, 1: CarbonImmutable}
     */
    private function dateRange(array $filters): array
    {
        $period = $filters['period'] ?? 'last_30_days';
        $now = CarbonImmutable::now();

        return match ($period) {
            'today' => [$now->startOfDay(), $now->endOfDay()],
            'last_7_days' => [$now->subDays(6)->startOfDay(), $now->endOfDay()],
            'quarter' => [$now->startOfQuarter(), $now->endOfQuarter()],
            'year' => [$now->startOfYear(), $now->endOfYear()],
            'custom' => [
                CarbonImmutable::parse((string) $filters['from'])->startOfDay(),
                CarbonImmutable::parse((string) $filters['to'])->endOfDay(),
            ],
            default => [$now->subDays(29)->startOfDay(), $now->endOfDay()],
        };
    }

    /**
     * @return array<string, int>
     */
    private function statusCounts(Builder $query): array
    {
        $counts = [];

        foreach (ReportStatus::cases() as $status) {
            $counts[$status->value] = 0;
        }

        $rows = (clone $query)
            ->select('status')
            ->selectRaw('COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        foreach ($rows as $status => $count) {
            if (array_key_exists((string) $status, $counts)) {
                $counts[(string) $status] = (int) $count;
            }
        }

        return $counts;
    }

    private function columnDistribution(Builder $query, string $column): array
    {
        return (clone $query)
            ->selectRaw("COALESCE({$column}, ?) as label, COUNT(*) as total", ['Unassigned'])
            ->groupBy($column)
            ->orderByDesc('total')
            ->get()
            ->map(fn (WeeklyReport $row): array => [
                'label' => $row->label,
                'total' => (int) $row->total,
            ])
            ->values()
            ->all();
    }

    /**
     * @param array<string, int> $statusCounts
     */
    private function formatStatusDistribution(array $statusCounts): array
    {
        return array_map(
            fn (ReportStatus $status): array => [
                'value' => $status->value,
                'label' => $status->label(),
                'color' => $status->color(),
                'count' => $statusCounts[$status->value] ?? 0,
            ],
            ReportStatus::cases(),
        );
    }

    private function averageApprovalTime(Builder $query): array
    {
        $reports = (clone $query)
            ->whereNotNull('submitted_at')
            ->where(function (Builder $query): void {
                $query
                    ->whereNotNull('generated_at')
                    ->orWhereNotNull('rejected_at')
                    ->orWhereNotNull('validated_at');
            })
            ->get();

        return $this->averageCompletionTime($reports, ['generated_at', 'rejected_at', 'validated_at'], 'submitted_at');
    }

    private function averageCompletionTime(
        Collection $reports,
        array $endFields = ['generated_at', 'rejected_at', 'validated_at'],
        string $startField = 'submitted_at',
    ): array {
        $durations = $reports
            ->map(function (WeeklyReport $report) use ($startField, $endFields): ?float {
                $start = $report->{$startField};

                if ($start === null) {
                    return null;
                }

                foreach ($endFields as $endField) {
                    $end = $report->{$endField};

                    if ($end !== null) {
                        return abs($start->diffInMinutes($end));
                    }
                }

                return null;
            })
            ->filter(fn (?float $minutes): bool => $minutes !== null);

        return $this->durationSummary((float) ($durations->avg() ?? 0));
    }

    private function bottleneckSummary(
        Builder $query,
        ReportStatus $status,
        string $startColumn,
        string $stage,
    ): array {
        $reports = (clone $query)
            ->where('status', $status)
            ->get();

        $durations = $reports
            ->map(function (WeeklyReport $report) use ($startColumn): ?float {
                $start = $report->{$startColumn} ?? $report->created_at;

                return $start === null
                    ? null
                    : abs($start->diffInMinutes(now()));
            })
            ->filter(fn (?float $minutes): bool => $minutes !== null);

        return [
            'stage' => $stage,
            'status' => $status->value,
            'pending_reports' => $reports->count(),
            'average_wait_time' => $this->durationSummary((float) ($durations->avg() ?? 0)),
        ];
    }

    private function durationSummary(float $minutes): array
    {
        $roundedMinutes = (int) round($minutes);
        $hours = round($minutes / 60, 2);

        return [
            'minutes' => $roundedMinutes,
            'hours' => $hours,
            'human' => $this->humanDuration($roundedMinutes),
        ];
    }

    private function humanDuration(int $minutes): string
    {
        if ($minutes <= 0) {
            return '0m';
        }

        $days = intdiv($minutes, 1440);
        $remainingMinutes = $minutes % 1440;
        $hours = intdiv($remainingMinutes, 60);
        $mins = $remainingMinutes % 60;
        $parts = [];

        if ($days > 0) {
            $parts[] = $days.'d';
        }

        if ($hours > 0) {
            $parts[] = $hours.'h';
        }

        if ($mins > 0 || $parts === []) {
            $parts[] = $mins.'m';
        }

        return implode(' ', $parts);
    }

    private function percentage(int $part, int $total): float
    {
        return $total > 0
            ? round(($part / $total) * 100, 2)
            : 0.0;
    }

    private function collectionStatusCount(Collection $reports, ReportStatus $status): int
    {
        return $reports
            ->filter(fn (WeeklyReport $report): bool => $report->status === $status)
            ->count();
    }

    private function trendKey(WeeklyReport $report, string $granularity): string
    {
        return match ($granularity) {
            'monthly' => $report->created_at->format('Y-m'),
            'yearly' => $report->created_at->format('Y'),
            default => $report->created_at->format('o-\WW'),
        };
    }

    private function trendLabel(string $period, string $granularity): string
    {
        return match ($granularity) {
            'monthly' => CarbonImmutable::createFromFormat('Y-m', $period)->format('F Y'),
            'yearly' => $period,
            default => $period,
        };
    }

    private function activityType(string $description): string
    {
        return match (true) {
            str_contains($description, 'rejet') || str_contains($description, 'rejet?') => 'rejection',
            str_contains($description, 'valid') || str_contains($description, 'approuv') => 'approval',
            str_contains($description, 'soumis') => 'submission',
            default => 'activity',
        };
    }
}
