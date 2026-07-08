<?php

namespace Tests\Feature\Notifications;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NotificationApiTest extends TestCase
{
    public function test_user_can_list_notifications_with_pagination_filters_search_and_sorting(): void
    {
        $user = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $matching = $this->createDatabaseNotification($user, [
            'data' => [
                'title' => 'Report submitted',
                'message' => 'Weekly report requires review.',
                'report_id' => 10,
            ],
            'type' => 'App\\Notifications\\WeeklyReportSubmittedNotification',
        ]);

        $this->createDatabaseNotification($user, [
            'data' => [
                'title' => 'System message',
                'message' => 'General platform notice.',
            ],
            'read_at' => now(),
            'type' => 'App\\Notifications\\SystemNotification',
        ]);

        $this->createDatabaseNotification($user, [
            'archived_at' => now(),
            'data' => [
                'title' => 'Archived report',
                'message' => 'Archived notification.',
                'report_id' => 11,
            ],
            'type' => 'App\\Notifications\\WeeklyReportSubmittedNotification',
        ]);

        $response = $this->getJson('/api/notifications?status=unread&type=workflow&search=Weekly&sort=created_at&direction=desc&per_page=10');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('meta.unread_count', 1)
            ->assertJsonPath('data.0.id', $matching->id)
            ->assertJsonPath('data.0.type', 'workflow')
            ->assertJsonPath('data.0.title', 'Report submitted')
            ->assertJsonPath('data.0.is_unread', true)
            ->assertJsonStructure([
                'success',
                'data' => [
                    [
                        'id',
                        'type',
                        'notification_type',
                        'title',
                        'message',
                        'data',
                        'related',
                        'action_url',
                        'is_read',
                        'is_unread',
                        'is_archived',
                        'read_at',
                        'archived_at',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'meta' => [
                    'current_page',
                    'last_page',
                    'per_page',
                    'total',
                    'unread_count',
                ],
            ]);
    }

    public function test_user_can_view_own_notification(): void
    {
        $user = $this->createEmployeeUser();
        $notification = $this->createDatabaseNotification($user);

        Sanctum::actingAs($user);

        $this->getJson("/api/notifications/{$notification->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $notification->id);
    }

    public function test_unread_count_excludes_read_and_archived_notifications(): void
    {
        $user = $this->createEmployeeUser();

        $this->createDatabaseNotification($user);
        $this->createDatabaseNotification($user, ['read_at' => now()]);
        $this->createDatabaseNotification($user, ['archived_at' => now()]);

        Sanctum::actingAs($user);

        $this->getJson('/api/notifications/unread-count')
            ->assertOk()
            ->assertJsonPath('data.count', 1);
    }

    public function test_user_can_mark_notification_as_read(): void
    {
        $user = $this->createEmployeeUser();
        $notification = $this->createDatabaseNotification($user);

        Sanctum::actingAs($user);

        $this->patchJson("/api/notifications/{$notification->id}/read")
            ->assertOk()
            ->assertJsonPath('data.is_read', true);

        $this->assertNotNull($notification->refresh()->read_at);
    }

    public function test_user_can_mark_all_visible_notifications_as_read(): void
    {
        $user = $this->createEmployeeUser();

        $first = $this->createDatabaseNotification($user);
        $second = $this->createDatabaseNotification($user);
        $archived = $this->createDatabaseNotification($user, ['archived_at' => now()]);

        Sanctum::actingAs($user);

        $this->patchJson('/api/notifications/read-all')
            ->assertOk()
            ->assertJsonPath('data.updated', 2)
            ->assertJsonPath('data.unread_count', 0);

        $this->assertNotNull($first->refresh()->read_at);
        $this->assertNotNull($second->refresh()->read_at);
        $this->assertNull($archived->refresh()->read_at);
    }

    public function test_user_can_archive_restore_and_delete_notification(): void
    {
        $user = $this->createEmployeeUser();
        $notification = $this->createDatabaseNotification($user);

        Sanctum::actingAs($user);

        $this->patchJson("/api/notifications/{$notification->id}/archive")
            ->assertOk()
            ->assertJsonPath('data.is_archived', true);

        $this->assertNotNull($notification->refresh()->archived_at);

        $this->getJson('/api/notifications?status=archived')
            ->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.id', $notification->id);

        $this->patchJson("/api/notifications/{$notification->id}/restore")
            ->assertOk()
            ->assertJsonPath('data.is_archived', false);

        $this->assertNull($notification->refresh()->archived_at);

        $this->deleteJson("/api/notifications/{$notification->id}")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('notifications', [
            'id' => $notification->id,
        ]);
    }

    private function createDatabaseNotification(User $user, array $attributes = []): DatabaseNotification
    {
        return $user->notifications()->create(array_merge([
            'id' => (string) Str::uuid(),
            'type' => 'App\\Notifications\\WeeklyReportSubmittedNotification',
            'data' => [
                'title' => 'Report notification',
                'message' => 'A report notification is available.',
                'report_id' => 1,
            ],
            'read_at' => null,
            'archived_at' => null,
        ], $attributes));
    }
}
