import { Bell } from 'lucide-react';
import type { ReactNode } from 'react';

import { EmptyState } from '@/components/ui';
import { NotificationItem } from '@/components/business/notifications/NotificationItem';
import type { NotificationItemProps } from '@/components/business/notifications/NotificationItem';

export type NotificationListEntry = NotificationItemProps & {
    id: string;
};

export type NotificationListProps = {
    emptyDescription?: ReactNode;
    emptyTitle?: ReactNode;
    notifications: readonly NotificationListEntry[];
    onNotificationSelect?: (notification: NotificationListEntry) => void;
};

export function NotificationList({
    emptyDescription = 'Notification items will appear here when available.',
    emptyTitle = 'No notifications',
    notifications,
    onNotificationSelect,
}: NotificationListProps) {
    if (notifications.length === 0) {
        return <EmptyState description={emptyDescription} icon={<Bell aria-hidden="true" className="size-10" />} title={emptyTitle} />;
    }

    return (
        <ul aria-label="Notifications" className="grid gap-3">
            {notifications.map((notification) => (
                <li key={notification.id}>
                    <NotificationItem {...notification} onSelect={onNotificationSelect ? () => onNotificationSelect(notification) : notification.onSelect} />
                </li>
            ))}
        </ul>
    );
}
