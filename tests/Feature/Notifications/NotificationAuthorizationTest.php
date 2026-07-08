<?php

namespace Tests\Feature\Notifications;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NotificationAuthorizationTest extends TestCase
{
    public function test_guest_cannot_access_notifications(): void
    {
        $this->getJson('/api/notifications')->assertUnauthorized();
        $this->getJson('/api/notifications/unread-count')->assertUnauthorized();
        $this->patchJson('/api/notifications/read-all')->assertUnauthorized();
    }

    public function test_user_cannot_access_another_users_notification(): void
    {
        $owner = $this->createEmployeeUser();
        $otherUser = $this->createEmployeeUser();
        $notification = $this->createDatabaseNotification($owner);

        Sanctum::actingAs($otherUser);

        $this->getJson("/api/notifications/{$notification->id}")->assertForbidden();
        $this->patchJson("/api/notifications/{$notification->id}/read")->assertForbidden();
        $this->patchJson("/api/notifications/{$notification->id}/archive")->assertForbidden();
        $this->patchJson("/api/notifications/{$notification->id}/restore")->assertForbidden();
        $this->deleteJson("/api/notifications/{$notification->id}")->assertForbidden();
    }

    public function test_user_list_only_contains_their_notifications(): void
    {
        $user = $this->createEmployeeUser();
        $otherUser = $this->createEmployeeUser();

        $ownNotification = $this->createDatabaseNotification($user);
        $this->createDatabaseNotification($otherUser);

        Sanctum::actingAs($user);

        $this->getJson('/api/notifications')
            ->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.id', $ownNotification->id);
    }

    private function createDatabaseNotification(User $user): DatabaseNotification
    {
        return $user->notifications()->create([
            'id' => (string) Str::uuid(),
            'type' => 'App\\Notifications\\WeeklyReportSubmittedNotification',
            'data' => [
                'title' => 'Report notification',
                'message' => 'A report notification is available.',
                'report_id' => 1,
            ],
            'read_at' => null,
            'archived_at' => null,
        ]);
    }
}
