import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';

import {
    archiveNotification,
    deleteNotification,
    getNotification,
    getUnreadNotificationCount,
    listNotifications,
    markAllNotificationsAsRead,
    markNotificationAsRead,
    notificationsQueryKeys,
    restoreNotification,
} from '@/services/notifications.service';
import type { ListNotificationsParams } from '@/services/notifications.service';
import type { ApiSuccessResponse, AppNotification, NotificationsPaginatedResponse } from '@/types';

const updateNotificationInLists = (queryClient: ReturnType<typeof useQueryClient>, notification: AppNotification) => {
    queryClient.setQueryData<ApiSuccessResponse<AppNotification>>(notificationsQueryKeys.detail(notification.id), {
        data: notification,
        success: true,
    });

    queryClient.setQueriesData<NotificationsPaginatedResponse>({ queryKey: notificationsQueryKeys.lists() }, (current) => {
        if (!current) {
            return current;
        }

        return {
            ...current,
            data: current.data.map((item) => (item.id === notification.id ? notification : item)),
            meta: {
                ...current.meta,
                unread_count: notification.is_read ? Math.max(0, current.meta.unread_count - 1) : current.meta.unread_count,
            },
        };
    });
};

const removeNotificationFromLists = (queryClient: ReturnType<typeof useQueryClient>, id: string) => {
    queryClient.setQueriesData<NotificationsPaginatedResponse>({ queryKey: notificationsQueryKeys.lists() }, (current) => {
        if (!current) {
            return current;
        }

        return {
            ...current,
            data: current.data.filter((notification) => notification.id !== id),
            meta: {
                ...current.meta,
                total: Math.max(0, current.meta.total - 1),
            },
        };
    });
};

export const useNotificationsQuery = (params: ListNotificationsParams = {}) =>
    useQuery({
        queryFn: ({ signal }) => listNotifications({ ...params, signal }),
        queryKey: notificationsQueryKeys.list(params),
        staleTime: 30_000,
    });

export const useNotificationQuery = (id: string | undefined) =>
    useQuery({
        enabled: Boolean(id),
        queryFn: ({ signal }) => getNotification(id as string, { signal }),
        queryKey: id ? notificationsQueryKeys.detail(id) : ['notifications', 'detail', 'invalid'],
    });

export const useUnreadNotificationsCountQuery = () =>
    useQuery({
        queryFn: ({ signal }) => getUnreadNotificationCount({ signal }),
        queryKey: notificationsQueryKeys.count(),
        staleTime: 30_000,
    });

export const useMarkNotificationReadMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (id: string) => markNotificationAsRead(id),
        onSuccess: (response) => {
            updateNotificationInLists(queryClient, response.data);
            void queryClient.invalidateQueries({ queryKey: notificationsQueryKeys.count() });
        },
    });
};

export const useMarkAllNotificationsReadMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: () => markAllNotificationsAsRead(),
        onSuccess: (response) => {
            queryClient.setQueriesData<NotificationsPaginatedResponse>({ queryKey: notificationsQueryKeys.lists() }, (current) => {
                if (!current) {
                    return current;
                }

                const readAt = new Date().toISOString();

                return {
                    ...current,
                    data: current.data.map((notification) => ({
                        ...notification,
                        is_read: true,
                        is_unread: false,
                        read_at: notification.read_at ?? readAt,
                    })),
                    meta: {
                        ...current.meta,
                        unread_count: 0,
                    },
                };
            });
            queryClient.setQueryData(notificationsQueryKeys.count(), {
                data: { count: response.data.unread_count },
                success: true,
            });
            void queryClient.invalidateQueries({ queryKey: notificationsQueryKeys.lists() });
        },
    });
};

export const useArchiveNotificationMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (id: string) => archiveNotification(id),
        onSuccess: (response) => {
            updateNotificationInLists(queryClient, response.data);
            void queryClient.invalidateQueries({ queryKey: notificationsQueryKeys.all });
        },
    });
};

export const useRestoreNotificationMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (id: string) => restoreNotification(id),
        onSuccess: (response) => {
            updateNotificationInLists(queryClient, response.data);
            void queryClient.invalidateQueries({ queryKey: notificationsQueryKeys.all });
        },
    });
};

export const useDeleteNotificationMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (id: string) => deleteNotification(id),
        onMutate: async (id) => {
            await queryClient.cancelQueries({ queryKey: notificationsQueryKeys.lists() });
            const previousLists = queryClient.getQueriesData<NotificationsPaginatedResponse>({ queryKey: notificationsQueryKeys.lists() });
            removeNotificationFromLists(queryClient, id);

            return { previousLists };
        },
        onError: (_error, _id, context) => {
            context?.previousLists.forEach(([queryKey, data]) => {
                queryClient.setQueryData(queryKey, data);
            });
        },
        onSettled: () => {
            void queryClient.invalidateQueries({ queryKey: notificationsQueryKeys.all });
        },
    });
};
