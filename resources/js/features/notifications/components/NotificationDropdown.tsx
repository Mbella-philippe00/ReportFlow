import { AlertCircle, Bell, CheckCheck, ExternalLink } from 'lucide-react';
import { useNavigate } from 'react-router-dom';

import { NotificationList } from '@/components/business/notifications';
import { Alert, Button, Skeleton } from '@/components/ui';
import { useToast } from '@/providers/ToastProvider';

import { useMarkAllNotificationsReadMutation, useMarkNotificationReadMutation, useNotificationsQuery } from '../hooks/useNotifications';
import { formatRelativeNotificationTime, notificationTypeMeta } from '../utils/notification-utils';

const getErrorMessage = (error: unknown) => (error instanceof Error ? error.message : 'Notifications could not be loaded.');

export type NotificationDropdownProps = {
    onClose: () => void;
};

export function NotificationDropdown({ onClose }: NotificationDropdownProps) {
    const navigate = useNavigate();
    const { notify } = useToast();
    const notificationsQuery = useNotificationsQuery({ per_page: 5, sort: '-created_at', status: 'all' });
    const markAsRead = useMarkNotificationReadMutation();
    const markAllAsRead = useMarkAllNotificationsReadMutation();
    const notifications = notificationsQuery.data?.data ?? [];
    const unreadCount = notificationsQuery.data?.meta.unread_count ?? 0;

    const openNotification = async (id: string, isUnread: boolean) => {
        if (isUnread) {
            try {
                await markAsRead.mutateAsync(id);
            } catch (error) {
                notify({ description: getErrorMessage(error), intent: 'error', title: 'Unable to mark notification as read' });
            }
        }

        onClose();
        navigate(`/notifications/${id}`);
    };

    const markAll = async () => {
        try {
            const response = await markAllAsRead.mutateAsync();
            notify({ description: `${response.data.updated} notifications updated.`, intent: 'success', title: 'Notifications marked as read' });
        } catch (error) {
            notify({ description: getErrorMessage(error), intent: 'error', title: 'Bulk action failed' });
        }
    };

    return (
        <div className="grid gap-4">
            <div className="flex items-start justify-between gap-4">
                <div>
                    <p className="font-semibold text-surface-foreground">Notifications</p>
                    <p className="mt-1 text-xs text-muted-foreground">{unreadCount} unread notification{unreadCount === 1 ? '' : 's'}</p>
                </div>
                <Button disabled={unreadCount === 0} leftIcon={<CheckCheck aria-hidden="true" className="size-4" />} loading={markAllAsRead.isPending} onClick={() => void markAll()} size="sm" variant="ghost">
                    Mark all read
                </Button>
            </div>

            {notificationsQuery.isError && (
                <Alert description={getErrorMessage(notificationsQuery.error)} icon={<AlertCircle aria-hidden="true" className="size-4" />} intent="danger" title="Unable to load" />
            )}

            {notificationsQuery.isLoading ? (
                <div className="grid gap-3">
                    {Array.from({ length: 3 }, (_, index) => (
                        <Skeleton className="h-20" key={index} />
                    ))}
                </div>
            ) : (
                <NotificationList
                    emptyDescription="Workflow, report, employee, system, AI, and administration updates will appear here."
                    emptyTitle="No recent notifications"
                    notifications={notifications.map((notification) => {
                        const meta = notificationTypeMeta[notification.type];
                        const Icon = meta.icon;

                        return {
                            description: notification.message,
                            icon: <Icon aria-hidden="true" className="size-4" />,
                            id: notification.id,
                            time: formatRelativeNotificationTime(notification.created_at),
                            title: notification.title,
                            unread: notification.is_unread,
                        };
                    })}
                    onNotificationSelect={(notification) => {
                        const selected = notifications.find((item) => item.id === notification.id);

                        if (selected) {
                            void openNotification(selected.id, selected.is_unread);
                        }
                    }}
                />
            )}

            <Button
                onClick={() => {
                    onClose();
                    navigate('/notifications');
                }}
                rightIcon={<ExternalLink aria-hidden="true" className="size-4" />}
                variant="outline"
            >
                Open notification center
            </Button>
        </div>
    );
}
