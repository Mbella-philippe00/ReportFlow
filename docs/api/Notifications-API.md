# Notifications API

## Overview

The Notifications API exposes Laravel database notifications to authenticated ReportFlow users. It reuses Laravel's `DatabaseNotification` model and the existing `notifications` table. Users can only access notifications where they are the notifiable user.

## Authentication

All endpoints require Sanctum authentication.

```http
Authorization: Bearer <token>
Accept: application/json
```

## Authorization

Authorization is enforced through `DatabaseNotificationPolicy`.

| Operation | Authorization Rule |
| --- | --- |
| List notifications | Authenticated user can list only their own notifications. |
| View notification | Notification must belong to the authenticated user. |
| Mark as read | Notification must belong to the authenticated user. |
| Mark all as read | Only affects authenticated user's unarchived notifications. |
| Archive | Notification must belong to the authenticated user. |
| Restore | Notification must belong to the authenticated user. |
| Delete | Notification must belong to the authenticated user. |

## Notification Types

The API normalizes notification categories for frontend filtering.

| Type | Description |
| --- | --- |
| `workflow` | Workflow and report approval notifications. |
| `reports` | Report-related notifications. |
| `employees` | Employee-related notifications. |
| `system` | Platform or system notifications. |
| `ai` | AI-related notifications. |
| `administration` | Administrative notifications. |

## Endpoints

### List Notifications

```http
GET /api/notifications
```

#### Query Parameters

| Parameter | Type | Allowed Values | Default | Description |
| --- | --- | --- | --- | --- |
| `page` | integer | `>= 1` | `1` | Page number. |
| `per_page` | integer | `1..100` | `15` | Page size. |
| `status` | string | `all`, `unread`, `read`, `archived` | `all` | Notification state filter. |
| `type` | string | `workflow`, `reports`, `employees`, `system`, `ai`, `administration` | none | Normalized notification type filter. |
| `search` | string | max 255 chars | none | Searches notification data and class type. |
| `sort` | string | `created_at`, `read_at`, `type`, `-created_at`, `-read_at`, `-type` | `created_at` | Sort field. Prefix with `-` for descending. |
| `direction` | string | `asc`, `desc` | `desc` | Sort direction. |

#### Response

```json
{
  "success": true,
  "data": [
    {
      "id": "uuid",
      "type": "workflow",
      "notification_type": "WeeklyReportSubmittedNotification",
      "title": "Report submitted",
      "message": "Weekly report requires review.",
      "data": {
        "title": "Report submitted",
        "message": "Weekly report requires review.",
        "report_id": 10
      },
      "related": {
        "report_id": 10,
        "employee_id": null,
        "user_id": null
      },
      "action_url": "/reports/10",
      "is_read": false,
      "is_unread": true,
      "is_archived": false,
      "read_at": null,
      "archived_at": null,
      "created_at": "2026-07-08T00:00:00.000000Z",
      "updated_at": "2026-07-08T00:00:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 1,
    "unread_count": 1
  }
}
```

### Show Notification

```http
GET /api/notifications/{notification}
```

Returns one notification if it belongs to the authenticated user.

### Unread Count

```http
GET /api/notifications/unread-count
```

Returns the count of unread, unarchived notifications for the authenticated user.

```json
{
  "success": true,
  "data": {
    "count": 3
  }
}
```

### Mark Notification as Read

```http
PATCH /api/notifications/{notification}/read
```

Marks a single notification as read.

### Mark All Notifications as Read

```http
PATCH /api/notifications/read-all
```

Marks all unread, unarchived notifications for the authenticated user as read.

### Archive Notification

```http
PATCH /api/notifications/{notification}/archive
```

Archives a single notification. Archived notifications are excluded from the default list and unread count.

### Restore Notification

```http
PATCH /api/notifications/{notification}/restore
```

Restores an archived notification.

### Delete Notification

```http
DELETE /api/notifications/{notification}
```

Deletes a notification owned by the authenticated user.

## Error Responses

| Status | Meaning |
| --- | --- |
| `401` | User is not authenticated. |
| `403` | Notification does not belong to authenticated user. |
| `404` | Notification does not exist. |
| `422` | Query parameter validation failed. |

## Frontend Integration Notes

- Use `GET /api/notifications/unread-count` for the topbar unread badge.
- Use `GET /api/notifications?status=unread` for the unread tab.
- Use `GET /api/notifications` for the all tab.
- Use `GET /api/notifications?status=archived` for the archived tab.
- Use `PATCH /api/notifications/read-all` for bulk read action.
- Use archive/restore/delete mutations to update list and unread-count queries.

## Realtime Readiness

This API is compatible with future realtime delivery through Laravel Echo, WebSockets, Server-Sent Events, polling, or push notifications. Realtime channels should deliver event hints and allow the frontend to invalidate notification queries rather than duplicating notification state.
