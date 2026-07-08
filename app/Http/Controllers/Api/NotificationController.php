<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexNotificationRequest;
use App\Http\Resources\NotificationResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Gate;

class NotificationController extends Controller
{
    public function index(IndexNotificationRequest $request): JsonResponse
    {
        Gate::authorize('viewAny', DatabaseNotification::class);

        $query = $request->user()
            ->notifications()
            ->getQuery();

        $this->applyFilters($query, $request);
        $this->applySorting($query, $request);

        $notifications = $query->paginate(
            $request->integer('per_page', 15)
        );

        return response()->json([
            'success' => true,
            'data' => NotificationResource::collection($notifications),
            'meta' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
                'unread_count' => $this->unreadCountFor($request->user()),
            ],
        ]);
    }

    public function show(DatabaseNotification $notification): JsonResponse
    {
        Gate::authorize('view', $notification);

        return response()->json([
            'success' => true,
            'data' => new NotificationResource($notification),
        ]);
    }

    public function unreadCount(IndexNotificationRequest $request): JsonResponse
    {
        Gate::authorize('viewAny', DatabaseNotification::class);

        return response()->json([
            'success' => true,
            'data' => [
                'count' => $this->unreadCountFor($request->user()),
            ],
        ]);
    }

    public function markAsRead(DatabaseNotification $notification): JsonResponse
    {
        Gate::authorize('update', $notification);

        if ($notification->read_at === null) {
            $notification->markAsRead();
            $notification->refresh();
        }

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.',
            'data' => new NotificationResource($notification),
        ]);
    }

    public function markAllAsRead(IndexNotificationRequest $request): JsonResponse
    {
        Gate::authorize('viewAny', DatabaseNotification::class);

        $updated = $request->user()
            ->unreadNotifications()
            ->whereNull('archived_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Notifications marked as read.',
            'data' => [
                'updated' => $updated,
                'unread_count' => 0,
            ],
        ]);
    }

    public function archive(DatabaseNotification $notification): JsonResponse
    {
        Gate::authorize('update', $notification);

        if ($notification->archived_at === null) {
            $notification->forceFill([
                'archived_at' => now(),
            ])->save();

            $notification->refresh();
        }

        return response()->json([
            'success' => true,
            'message' => 'Notification archived.',
            'data' => new NotificationResource($notification),
        ]);
    }

    public function restore(DatabaseNotification $notification): JsonResponse
    {
        Gate::authorize('update', $notification);

        if ($notification->archived_at !== null) {
            $notification->forceFill([
                'archived_at' => null,
            ])->save();

            $notification->refresh();
        }

        return response()->json([
            'success' => true,
            'message' => 'Notification restored.',
            'data' => new NotificationResource($notification),
        ]);
    }

    public function destroy(DatabaseNotification $notification): JsonResponse
    {
        Gate::authorize('delete', $notification);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted.',
        ]);
    }

    private function applyFilters(Builder $query, IndexNotificationRequest $request): void
    {
        $status = $request->validated('status', 'all');

        match ($status) {
            'archived' => $query->whereNotNull('archived_at'),
            'read' => $query->whereNotNull('read_at')->whereNull('archived_at'),
            'unread' => $query->whereNull('read_at')->whereNull('archived_at'),
            default => $query->whereNull('archived_at'),
        };

        $type = $request->validated('type');

        if (is_string($type) && $type !== '') {
            $this->applyTypeFilter($query, $type);
        }

        $search = $request->validated('search');

        if (is_string($search) && trim($search) !== '') {
            $term = '%'.trim($search).'%';

            $query->where(function (Builder $query) use ($term): void {
                $query
                    ->where('data', 'like', $term)
                    ->orWhere('type', 'like', $term);
            });
        }
    }

    private function applySorting(Builder $query, IndexNotificationRequest $request): void
    {
        $sort = $request->validated('sort') ?? 'created_at';
        $direction = $request->validated('direction') ?? 'desc';

        if (str_starts_with($sort, '-')) {
            $sort = substr($sort, 1);
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);
    }

    private function applyTypeFilter(Builder $query, string $type): void
    {
        match ($type) {
            'administration' => $query->where('type', 'like', '%Admin%'),
            'ai' => $query->where(function (Builder $query): void {
                $query
                    ->where('type', 'like', '%Ai%')
                    ->orWhere('type', 'like', '%AI%');
            }),
            'employees' => $query->where(function (Builder $query): void {
                $query
                    ->where('type', 'like', '%Employee%')
                    ->orWhere('data', 'like', '%employee_id%');
            }),
            'reports' => $query->where(function (Builder $query): void {
                $query
                    ->where('type', 'like', '%Report%')
                    ->orWhere('data', 'like', '%report_id%');
            }),
            'workflow' => $query->where(function (Builder $query): void {
                $query
                    ->where('type', 'like', '%Report%')
                    ->orWhere('data', 'like', '%report_id%');
            }),
            default => $query->where(function (Builder $query): void {
                $query
                    ->where('type', 'not like', '%Report%')
                    ->where('type', 'not like', '%Employee%')
                    ->where('type', 'not like', '%Admin%')
                    ->where('type', 'not like', '%Ai%')
                    ->where('type', 'not like', '%AI%');
            }),
        };
    }

    private function unreadCountFor(mixed $user): int
    {
        return $user
            ->unreadNotifications()
            ->whereNull('archived_at')
            ->count();
    }
}

