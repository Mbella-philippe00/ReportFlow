import { http } from '@/lib/http';
import type {
    ApiMessageResponse,
    ApiSuccessResponse,
    AppNotification,
    MarkAllNotificationsReadResult,
    NotificationSortValue,
    NotificationStatusFilter,
    NotificationType,
    NotificationUnreadCount,
    NotificationsPaginatedResponse,
} from '@/types';

export type ListNotificationsParams = {
    direction?: 'asc' | 'desc';
    page?: number;
    per_page?: number;
    search?: string;
    sort?: NotificationSortValue;
    status?: NotificationStatusFilter;
    type?: '' | NotificationType;
};

export type ListNotificationsOptions = ListNotificationsParams & {
    signal?: AbortSignal;
};

export type NotificationMutationOptions = {
    signal?: AbortSignal;
};

const buildNotificationsPath = (path = '/notifications', params: ListNotificationsParams = {}) => {
    const searchParams = new URLSearchParams();

    Object.entries(params).forEach(([key, value]) => {
        if (value !== undefined && value !== null && value !== '') {
            searchParams.set(key, String(value));
        }
    });

    const queryString = searchParams.toString();

    return queryString ? `${path}?${queryString}` : path;
};

export const notificationsQueryKeys = {
    all: ['notifications'] as const,
    count: () => ['notifications', 'unread-count'] as const,
    detail: (id: string) => ['notifications', 'detail', id] as const,
    lists: () => ['notifications', 'list'] as const,
    list: (params: ListNotificationsParams = {}) => ['notifications', 'list', params] as const,
};

export const listNotifications = ({ signal, ...params }: ListNotificationsOptions = {}) =>
    http<NotificationsPaginatedResponse>(buildNotificationsPath('/notifications', params), {
        signal,
    });

export const getNotification = (id: string, { signal }: NotificationMutationOptions = {}) =>
    http<ApiSuccessResponse<AppNotification>>(`/notifications/${id}`, {
        signal,
    });

export const getUnreadNotificationCount = ({ signal }: NotificationMutationOptions = {}) =>
    http<ApiSuccessResponse<NotificationUnreadCount>>('/notifications/unread-count', {
        signal,
    });

export const markNotificationAsRead = (id: string, { signal }: NotificationMutationOptions = {}) =>
    http<ApiSuccessResponse<AppNotification>>(`/notifications/${id}/read`, {
        method: 'PATCH',
        signal,
    });

export const markAllNotificationsAsRead = ({ signal }: NotificationMutationOptions = {}) =>
    http<ApiSuccessResponse<MarkAllNotificationsReadResult>>('/notifications/read-all', {
        method: 'PATCH',
        signal,
    });

export const archiveNotification = (id: string, { signal }: NotificationMutationOptions = {}) =>
    http<ApiSuccessResponse<AppNotification>>(`/notifications/${id}/archive`, {
        method: 'PATCH',
        signal,
    });

export const restoreNotification = (id: string, { signal }: NotificationMutationOptions = {}) =>
    http<ApiSuccessResponse<AppNotification>>(`/notifications/${id}/restore`, {
        method: 'PATCH',
        signal,
    });

export const deleteNotification = (id: string, { signal }: NotificationMutationOptions = {}) =>
    http<ApiMessageResponse>(`/notifications/${id}`, {
        method: 'DELETE',
        signal,
    });
