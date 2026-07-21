<?php

namespace App\Services\AI;

use App\Models\User;
use App\Models\WeeklyReport;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Activitylog\Models\Activity;

class AiHistoryService
{
    public function __construct(
        protected ProviderResolver $providers,
    ) {}

    public function logGeneration(
        User $user,
        WeeklyReport $report,
        string $action,
        string $content,
        array $metadata = [],
    ): Activity {
        return activity('ai')
            ->performedOn($report)
            ->causedBy($user)
            ->withProperties([
                'action' => $action,
                'content' => $content,
                'provider' => $metadata['provider'] ?? $this->providerName(),
                'model' => $metadata['model'] ?? $this->modelName(),
                'section' => $metadata['section'] ?? null,
                'persisted' => $metadata['persisted'] ?? false,
            ])
            ->log('AI generation completed');
    }

    public function list(User $user, array $filters): LengthAwarePaginator
    {
        $query = Activity::query()
            ->with(['causer', 'subject'])
            ->where('log_name', 'ai')
            ->latest();

        if (($filters['scope'] ?? 'mine') !== 'all' || ! $user->hasAnyRole(['manager', 'super-admin'])) {
            $query
                ->where('causer_type', User::class)
                ->where('causer_id', $user->id);
        }

        if (! blank($filters['action'] ?? null)) {
            $query->where('properties->action', $filters['action']);
        }

        if (! blank($filters['report_id'] ?? null)) {
            $query
                ->where('subject_type', WeeklyReport::class)
                ->where('subject_id', (int) $filters['report_id']);
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    public function dashboard(User $user): array
    {
        $baseQuery = Activity::query()
            ->where('log_name', 'ai')
            ->where('causer_type', User::class)
            ->where('causer_id', $user->id);

        $totalGenerations = (clone $baseQuery)->count();
        $todayGenerations = (clone $baseQuery)
            ->whereDate('created_at', now()->toDateString())
            ->count();

        $recent = (clone $baseQuery)
            ->with(['causer', 'subject'])
            ->latest()
            ->take(5)
            ->get();

        $byAction = (clone $baseQuery)
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(properties, '$.action')) as action, COUNT(*) as total")
            ->groupBy('action')
            ->orderByDesc('total')
            ->get()
            ->map(fn (Activity $activity): array => [
                'action' => $activity->action ?? 'unknown',
                'total' => (int) $activity->total,
            ])
            ->values();

        return [
            'total_generations' => $totalGenerations,
            'today_generations' => $todayGenerations,
            'available_actions' => AiPromptCatalog::ALL_ACTIONS,
            'providers' => $this->providers(),
            'by_action' => $byAction,
            'recent' => $recent,
        ];
    }

    public function providers(): array
    {
        return $this->providers->providers();
    }

    private function providerName(): string
    {
        return $this->providers->activeProvider();
    }

    private function modelName(): string
    {
        return (string) $this->providers->model($this->providers->activeProvider());
    }
}