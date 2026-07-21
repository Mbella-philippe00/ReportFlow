<?php

namespace App\Services\Analytics;

use App\Enums\ReportStatus;
use App\Models\Employee;
use App\Models\ReportDocument;
use App\Models\WeeklyReport;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ExecutiveAnalyticsService
{
    public function dashboard(array $filters): array
    {
        $reports = $this->reports($filters);
        $counts = $this->statusCounts($reports);
        $decided = $counts['approved'] + $counts['rejected'];
        $alerts = $this->alerts($filters);

        return $this->dataset('executive_dashboard', [
            'headline_metrics' => [
                'total_reports' => $reports->count(),
                'completion_rate' => $this->pct($reports->where('status', '!=', ReportStatus::DRAFT)->count(), $reports->count()),
                'approval_rate' => $this->pct($counts['approved'], $decided),
                'pending_reports' => $counts['submitted'] + $counts['under_review'],
                'rejected_reports' => $counts['rejected'],
                'documents_count' => $this->documentsQuery($filters)->count(),
                'smart_alerts_count' => count($alerts['data']),
                'average_approval_time' => $this->avgTime($reports),
            ],
            'trendlines' => $this->trends($reports, $filters['granularity'] ?? 'weekly'),
            'department_leaders' => array_slice($this->departments($reports), 0, 5),
            'employee_leaders' => array_slice($this->employees($reports), 0, 5),
            'workflow_health' => [
                'stage_counts' => $counts,
                'bottlenecks' => [
                    'manager_approval' => $this->pendingTime($reports, ReportStatus::SUBMITTED, 'submitted_at'),
                    'final_approval' => $this->pendingTime($reports, ReportStatus::UNDER_REVIEW, 'validated_at'),
                ],
            ],
            'smart_alerts' => array_slice($alerts['data'], 0, 5),
        ]);
    }

    public function kpiCenter(array $filters): array
    {
        $reports = $this->reports($filters);
        $counts = $this->statusCounts($reports);
        $active = $reports->count() - $counts['draft'];
        $decided = $counts['approved'] + $counts['rejected'];
        $documents = $this->documentsQuery($filters)->count();

        return $this->dataset('kpi_center', [
            'kpis' => [
                $this->kpi('report_volume', 'Report volume', $reports->count(), 'reports', 120, true),
                $this->kpi('completion_rate', 'Completion rate', $this->pct($active, $reports->count()), '%', 85, true),
                $this->kpi('approval_rate', 'Approval rate', $this->pct($counts['approved'], $decided), '%', 80, true),
                $this->kpi('rejection_rate', 'Rejection rate', $this->pct($counts['rejected'], $decided), '%', 15, false),
                $this->kpi('pending_reports', 'Pending workflow', $counts['submitted'] + $counts['under_review'], 'reports', 20, false),
                $this->kpi('approval_cycle_time', 'Approval cycle time', $this->avgTime($reports)['hours'], 'hours', 48, false),
                $this->kpi('document_coverage', 'Document coverage', $this->pct($documents, max($active, 1)), '%', 65, true),
            ],
            'categories' => [
                'execution' => ['report_volume', 'completion_rate', 'document_coverage'],
                'quality' => ['approval_rate', 'rejection_rate'],
                'workflow' => ['pending_reports', 'approval_cycle_time'],
            ],
        ]);
    }

    public function comparisons(array $filters): array
    {
        $reports = $this->reports($filters);

        return $this->dataset('comparisons', [
            'departments' => $this->departments($reports),
            'employees' => $this->employees($reports),
        ], [
            'department_count' => $reports->pluck('department')->filter()->unique()->count(),
            'employee_count' => $reports->pluck('employee_id')->filter()->unique()->count(),
        ]);
    }

    public function alerts(array $filters): array
    {
        $reports = $this->reports($filters);
        $alerts = [];
        $submitted = $reports->filter(fn (WeeklyReport $report) => $report->status === ReportStatus::SUBMITTED && $this->hoursSince($report->submitted_at) >= 48);
        $final = $reports->filter(fn (WeeklyReport $report) => $report->status === ReportStatus::UNDER_REVIEW && $this->hoursSince($report->validated_at ?? $report->under_review_at) >= 72);

        if ($submitted->isNotEmpty()) {
            $alerts[] = $this->alert('submitted_backlog', 'critical', 'Manager approval backlog', $submitted->count().' submitted reports have waited more than 48 hours.', 'workflow');
        }

        if ($final->isNotEmpty()) {
            $alerts[] = $this->alert('final_approval_backlog', 'high', 'Final approval aging', $final->count().' reports are under review for more than 72 hours.', 'workflow');
        }

        foreach ($this->departments($reports) as $department) {
            if ($department['total_reports'] >= 3 && $department['completion_rate'] < 60) {
                $alerts[] = $this->alert('department_'.$department['department'], 'medium', 'Department completion risk', $department['department'].' completion rate is '.$department['completion_rate'].'%.', 'department');
            }
        }

        $counts = $this->statusCounts($reports);
        $rate = $this->pct($counts['rejected'], $counts['approved'] + $counts['rejected']);

        if (($counts['approved'] + $counts['rejected']) >= 5 && $rate >= 25) {
            $alerts[] = $this->alert('rejection_rate', 'medium', 'Elevated rejection rate', 'Rejection rate is '.$rate.'% across decided reports.', 'quality');
        }

        return $this->dataset('smart_alerts', $alerts, [
            'critical' => collect($alerts)->where('severity', 'critical')->count(),
            'high' => collect($alerts)->where('severity', 'high')->count(),
            'medium' => collect($alerts)->where('severity', 'medium')->count(),
            'total_alerts' => count($alerts),
        ]);
    }

    public function executiveReport(array $filters): array
    {
        $dashboard = $this->dashboard($filters)['data'];
        $comparisons = $this->comparisons($filters)['data'];
        $headline = $dashboard['headline_metrics'];

        return $this->dataset('executive_report', [
            'title' => 'ReportFlow Executive Decision Brief',
            'generated_at' => now()->toISOString(),
            'summary' => [
                'Reports analyzed: '.$headline['total_reports'],
                'Completion rate: '.$headline['completion_rate'].'%',
                'Approval rate: '.$headline['approval_rate'].'%',
                'Open workflow items: '.$headline['pending_reports'],
            ],
            'decision_points' => collect($dashboard['smart_alerts'])->take(4)->values()->all(),
            'department_focus' => array_slice($comparisons['departments'], 0, 3),
            'employee_focus' => array_slice($comparisons['employees'], 0, 5),
            'recommendations' => $this->recommend($headline, $dashboard['smart_alerts']),
        ]);
    }

    public function exportOptions(): array
    {
        return [
            'supported' => true,
            'available_formats' => ['csv', 'xlsx', 'pdf'],
            'message' => 'Executive analytics can be exported as CSV, Excel, or PDF.',
            'future_formats' => [],
            'datasets' => ['executive', 'kpis', 'comparisons', 'alerts'],
        ];
    }

    public function export(string $format, string $dataset, array $filters): array
    {
        $rows = $this->rows($dataset, $filters);
        $name = 'reportflow-'.$dataset.'-analytics-'.now()->format('Ymd-His');

        return match ($format) {
            'pdf' => ['content' => $this->pdf($dataset, $rows), 'content_type' => 'application/pdf', 'filename' => $name.'.pdf'],
            'xlsx' => ['content' => $this->excelXml($rows), 'content_type' => 'application/vnd.ms-excel', 'filename' => $name.'.xls'],
            default => ['content' => $this->csv($rows), 'content_type' => 'text/csv', 'filename' => $name.'.csv'],
        };
    }

    private function reports(array $filters): Collection
    {
        return $this->filteredReportsQuery($filters)->with('employee')->get();
    }

    private function filteredReportsQuery(array $filters): Builder
    {
        [$from, $to] = $this->dateRange($filters);
        $query = WeeklyReport::query()->whereBetween('created_at', [$from, $to]);

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

    private function documentsQuery(array $filters): Builder
    {
        [$from, $to] = $this->dateRange($filters);
        $query = ReportDocument::query()->whereBetween('created_at', [$from, $to]);

        if (! blank($filters['department'] ?? null)) {
            $query->whereHas('report', fn (Builder $reports) => $reports->where('department', trim((string) $filters['department'])));
        }

        if (! blank($filters['employee'] ?? null)) {
            $query->whereHas('report', fn (Builder $reports) => $reports->where('employee_id', (int) $filters['employee']));
        }

        return $query;
    }

    private function dateRange(array $filters): array
    {
        $period = $filters['period'] ?? 'last_30_days';
        $now = CarbonImmutable::now();

        return match ($period) {
            'today' => [$now->startOfDay(), $now->endOfDay()],
            'last_7_days' => [$now->subDays(6)->startOfDay(), $now->endOfDay()],
            'quarter' => [$now->startOfQuarter(), $now->endOfQuarter()],
            'year' => [$now->startOfYear(), $now->endOfYear()],
            'custom' => [CarbonImmutable::parse((string) $filters['from'])->startOfDay(), CarbonImmutable::parse((string) $filters['to'])->endOfDay()],
            default => [$now->subDays(29)->startOfDay(), $now->endOfDay()],
        };
    }

    private function statusCounts(Collection $reports): array
    {
        return collect(ReportStatus::cases())
            ->mapWithKeys(fn (ReportStatus $status) => [$status->value => $reports->filter(fn (WeeklyReport $report) => $report->status === $status)->count()])
            ->all();
    }

    private function trends(Collection $reports, string $granularity): array
    {
        return $reports->groupBy(fn (WeeklyReport $report) => match ($granularity) {
            'monthly' => $report->created_at->format('Y-m'),
            'yearly' => $report->created_at->format('Y'),
            default => $report->created_at->format('o-\WW'),
        })->sortKeys()->map(fn (Collection $items, string $period) => [
            'period' => $period,
            'label' => $period,
            'total_reports' => $items->count(),
            'approved_reports' => $items->where('status', ReportStatus::APPROVED)->count(),
            'rejected_reports' => $items->where('status', ReportStatus::REJECTED)->count(),
            'pending_reports' => $items->filter(fn (WeeklyReport $report) => in_array($report->status, [ReportStatus::SUBMITTED, ReportStatus::UNDER_REVIEW], true))->count(),
        ])->values()->all();
    }

    private function departments(Collection $reports): array
    {
        return $reports->groupBy(fn (WeeklyReport $report) => $report->department ?: 'Unassigned')
            ->map(function (Collection $items, string $department) {
                $approved = $items->where('status', ReportStatus::APPROVED)->count();
                $rejected = $items->where('status', ReportStatus::REJECTED)->count();
                $completion = $this->pct($items->where('status', '!=', ReportStatus::DRAFT)->count(), $items->count());
                $approval = $this->pct($approved, $approved + $rejected);

                return [
                    'department' => $department,
                    'active_employees' => Employee::query()->where('department', $department === 'Unassigned' ? null : $department)->where('active', true)->count(),
                    'total_reports' => $items->count(),
                    'approved_reports' => $approved,
                    'rejected_reports' => $rejected,
                    'pending_reports' => $items->filter(fn (WeeklyReport $report) => in_array($report->status, [ReportStatus::SUBMITTED, ReportStatus::UNDER_REVIEW], true))->count(),
                    'completion_rate' => $completion,
                    'approval_rate' => $approval,
                    'score' => round(($completion * 0.45) + ($approval * 0.45) + min($items->count(), 10), 2),
                ];
            })->sortByDesc('score')->values()->map(fn (array $item, int $index) => ['rank' => $index + 1, ...$item])->all();
    }

    private function employees(Collection $reports): array
    {
        return $reports->filter(fn (WeeklyReport $report) => $report->employee !== null)->groupBy('employee_id')
            ->map(function (Collection $items) {
                $employee = $items->first()->employee;
                $approved = $items->where('status', ReportStatus::APPROVED)->count();
                $rejected = $items->where('status', ReportStatus::REJECTED)->count();
                $submitted = $items->filter(fn (WeeklyReport $report) => $report->submitted_at !== null)->count();
                $approval = $this->pct($approved, $approved + $rejected);
                $submission = $this->pct($submitted, $items->count());

                return [
                    'employee' => ['id' => $employee->id, 'name' => $employee->full_name, 'email' => $employee->email, 'department' => $employee->department],
                    'total_reports' => $items->count(),
                    'submitted_reports' => $submitted,
                    'approved_reports' => $approved,
                    'approval_rate' => $approval,
                    'submission_rate' => $submission,
                    'average_completion_time' => $this->avgTime($items),
                    'score' => round(($approval * 0.55) + ($submission * 0.35) + min($items->count(), 10), 2),
                ];
            })->sortByDesc('score')->values()->map(fn (array $item, int $index) => ['rank' => $index + 1, ...$item])->all();
    }

    private function kpi(string $id, string $label, float|int $value, string $unit, float|int $target, bool $higherIsBetter): array
    {
        $delta = $higherIsBetter ? $value - $target : $target - $value;

        return ['id' => $id, 'label' => $label, 'value' => round((float) $value, 2), 'unit' => $unit, 'target' => $target, 'delta' => round($delta, 2), 'status' => $delta >= 0 ? 'on_track' : 'attention'];
    }

    private function alert(string $id, string $severity, string $title, string $message, string $category): array
    {
        return compact('id', 'severity', 'title', 'message', 'category') + ['created_at' => now()->toISOString()];
    }

    private function dataset(string $type, array $data, array $meta = []): array
    {
        return ['type' => $type, 'data' => $data, 'meta' => ['generated_at' => now()->toISOString(), ...$meta]];
    }

    private function rows(string $dataset, array $filters): array
    {
        return match ($dataset) {
            'alerts' => collect($this->alerts($filters)['data'])->map(fn ($row) => ['severity' => $row['severity'], 'category' => $row['category'], 'title' => $row['title'], 'message' => $row['message']])->all(),
            'comparisons' => collect($this->comparisons($filters)['data']['departments'])->map(fn ($row) => ['rank' => $row['rank'], 'department' => $row['department'], 'total_reports' => $row['total_reports'], 'completion_rate' => $row['completion_rate'], 'approval_rate' => $row['approval_rate'], 'score' => $row['score']])->all(),
            'kpis' => collect($this->kpiCenter($filters)['data']['kpis'])->map(fn ($row) => ['kpi' => $row['label'], 'value' => $row['value'], 'unit' => $row['unit'], 'target' => $row['target'], 'status' => $row['status']])->all(),
            default => collect($this->dashboard($filters)['data']['headline_metrics'])->map(fn ($value, $metric) => ['metric' => $metric, 'value' => is_array($value) ? $value['human'] : $value])->values()->all(),
        };
    }

    private function csv(array $rows): string
    {
        if ($rows === []) {
            return '';
        }

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, array_keys($rows[0]));
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);

        return stream_get_contents($handle);
    }

    private function excelXml(array $rows): string
    {
        $rows = $rows === [] ? [['message' => 'No data']] : $rows;
        $sheetRows = [array_keys($rows[0]), ...array_map(fn ($row) => array_values($row), $rows)];
        $body = collect($sheetRows)->map(function (array $row) {
            $cells = collect($row)->map(fn ($value) => '<Cell><Data ss:Type=\'String\'>'.htmlspecialchars((string) $value, ENT_XML1 | ENT_QUOTES).'</Data></Cell>')->implode('');
            return '<Row>'.$cells.'</Row>';
        })->implode('');

        return '<?xml version=\'1.0\'?><Workbook xmlns=\'urn:schemas-microsoft-com:office:spreadsheet\' xmlns:ss=\'urn:schemas-microsoft-com:office:spreadsheet\'><Worksheet ss:Name=\'Executive Analytics\'><Table>'.$body.'</Table></Worksheet></Workbook>';
    }

    private function pdf(string $dataset, array $rows): string
    {
        $text = 'ReportFlow Executive Analytics - '.ucfirst($dataset).' - '.now()->toDateTimeString();
        foreach (array_slice($rows, 0, 20) as $row) {
            $text .= '\n'.implode(' | ', array_map(fn ($key, $value) => $key.': '.$value, array_keys($row), array_values($row)));
        }
        $stream = 'BT /F1 11 Tf 50 780 Td 14 TL ('.str_replace(['\\', '(', ')'], ['\\\\', '\(', '\)'], $text).') Tj ET';
        $objects = ['1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj', '2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj', '3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >> endobj', '4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj', '5 0 obj << /Length '.strlen($stream).' >> stream'.PHP_EOL.$stream.PHP_EOL.'endstream endobj'];
        $pdf = '%PDF-1.4'.PHP_EOL;
        $offsets = [0];
        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object.PHP_EOL;
        }
        $xref = strlen($pdf);
        $pdf .= 'xref'.PHP_EOL.'0 '.(count($objects) + 1).PHP_EOL.'0000000000 65535 f '.PHP_EOL;
        foreach (array_slice($offsets, 1) as $offset) {
            $pdf .= str_pad((string) $offset, 10, '0', STR_PAD_LEFT).' 00000 n '.PHP_EOL;
        }

        return $pdf.'trailer << /Size '.(count($objects) + 1).' /Root 1 0 R >>'.PHP_EOL.'startxref'.PHP_EOL.$xref.PHP_EOL.'%%EOF';
    }

    private function recommend(array $headline, array $alerts): array
    {
        return array_values(array_filter([
            $headline['pending_reports'] > 0 ? 'Run a manager approval sweep for pending reports.' : null,
            $headline['approval_rate'] < 75 ? 'Review rejection drivers and update report quality guidance.' : null,
            $alerts !== [] ? 'Assign owners to smart alerts and review progress within 48 hours.' : null,
        ])) ?: ['Maintain current workflow cadence and monitor KPI drift weekly.'];
    }

    private function avgTime(Collection $reports): array
    {
        $minutes = $reports->map(function (WeeklyReport $report) {
            if (! $report->submitted_at) {
                return null;
            }
            foreach (['generated_at', 'approved_at', 'rejected_at', 'validated_at'] as $field) {
                if ($report->{$field}) {
                    return abs($report->submitted_at->diffInMinutes($report->{$field}));
                }
            }
            return null;
        })->filter()->avg() ?? 0;

        return $this->duration((float) $minutes);
    }

    private function pendingTime(Collection $reports, ReportStatus $status, string $field): array
    {
        return $this->duration((float) ($reports->where('status', $status)->map(fn (WeeklyReport $report) => $report->{$field} ? abs($report->{$field}->diffInMinutes(now())) : null)->filter()->avg() ?? 0));
    }

    private function duration(float $minutes): array
    {
        $rounded = (int) round($minutes);

        return ['minutes' => $rounded, 'hours' => round($minutes / 60, 2), 'human' => $rounded >= 60 ? round($rounded / 60, 1).'h' : $rounded.'m'];
    }

    private function pct(int $part, int $total): float
    {
        return $total > 0 ? round(($part / $total) * 100, 2) : 0.0;
    }

    private function hoursSince($date): float
    {
        return $date ? abs($date->diffInMinutes(now())) / 60 : 0;
    }
}
