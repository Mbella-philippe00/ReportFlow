import { ExternalLink } from 'lucide-react';
import { useNavigate } from 'react-router-dom';

import { NotificationItem } from '@/components/business/notifications';
import { Button } from '@/components/ui';
import type { AppNotification } from '@/types';

import { formatRelativeNotificationTime, notificationTypeMeta } from '../utils/notification-utils';
import { NotificationActions } from './NotificationActions';
import { NotificationTypeBadge } from './NotificationTypeBadge';

export type NotificationCardProps = {
    isPending?: boolean;
    notification: AppNotification;
    onArchive: (notification: AppNotification) => void;
    onDelete: (notification: AppNotification) => void;
    onMarkAsRead: (notification: AppNotification) => void;
    onRestore: (notification: AppNotification) => void;
};

export function NotificationCard({ isPending = false, notification, onArchive, onDelete, onMarkAsRead, onRestore }: NotificationCardProps) {
    const navigate = useNavigate();
    const meta = notificationTypeMeta[notification.type];
    const Icon = meta.icon;

    return (
        <NotificationItem
            actions={
                <div className="flex flex-col items-start gap-3 sm:items-end">
                    <Button onClick={() => navigate(`/notifications/${notification.id}`)} rightIcon={<ExternalLink aria-hidden="true" className="size-4" />} size="sm" variant="outline">
                        Details
                    </Button>
                    <NotificationActions
                        compact
                        isPending={isPending}
                        notification={notification}
                        onArchive={onArchive}
                        onDelete={onDelete}
                        onMarkAsRead={onMarkAsRead}
                        onRestore={onRestore}
                    />
                </div>
            }
            description={notification.message}
            icon={<Icon aria-hidden="true" className="size-5" />}
            time={
                <span className="flex flex-wrap items-center gap-2">
                    <NotificationTypeBadge type={notification.type} />
                    <span>{formatRelativeNotificationTime(notification.created_at)}</span>
                </span>
            }
            title={notification.title}
            unread={notification.is_unread}
        />
    );
}
