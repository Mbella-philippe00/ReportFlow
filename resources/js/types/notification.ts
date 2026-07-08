export type NotificationType = 'administration' | 'ai' | 'employees' | 'reports' | 'system' | 'workflow';

export type NotificationStatusFilter = 'all' | 'archived' | 'read' | 'unread';

export type NotificationSortValue = '-created_at' | '-read_at' | '-type' | 'created_at' | 'read_at' | 'type';

export type NotificationRelated = {
    employee_id: number | null;
    report_id: number | null;
    user_id: number | null;
};

export type NotificationData = Record<string, unknown>;

export type AppNotification = {
    action_url: string | null;
    archived_at: string | null;
    created_at: string;
    data: NotificationData;
    id: string;
    is_archived: boolean;
    is_read: boolean;
    is_unread: boolean;
    message: string;
    notification_type: string;
    read_at: string | null;
    related: NotificationRelated;
    title: string;
    type: NotificationType;
    updated_at: string;
};

export type NotificationUnreadCount = {
    count: number;
};

export type NotificationsMeta = {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    unread_count: number;
};

export type NotificationsPaginatedResponse = {
    data: AppNotification[];
    meta: NotificationsMeta;
    success: true;
};

export type MarkAllNotificationsReadResult = {
    unread_count: number;
    updated: number;
};
