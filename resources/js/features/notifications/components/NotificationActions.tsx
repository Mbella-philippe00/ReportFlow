import { Archive, Check, RotateCcw, Trash2 } from 'lucide-react';

import { Button } from '@/components/ui';
import type { AppNotification } from '@/types';

export type NotificationActionsProps = {
    compact?: boolean;
    isPending?: boolean;
    notification: AppNotification;
    onArchive: (notification: AppNotification) => void;
    onDelete: (notification: AppNotification) => void;
    onMarkAsRead: (notification: AppNotification) => void;
    onRestore: (notification: AppNotification) => void;
};

export function NotificationActions({ compact = false, isPending = false, notification, onArchive, onDelete, onMarkAsRead, onRestore }: NotificationActionsProps) {
    const size = compact ? 'sm' : 'md';
    const labelClassName = compact ? 'sr-only' : undefined;

    return (
        <div className="flex flex-wrap items-center gap-2">
            {notification.is_unread && !notification.is_archived && (
                <Button leftIcon={<Check aria-hidden="true" className="size-4" />} loading={isPending} onClick={() => onMarkAsRead(notification)} size={size} variant="outline">
                    <span className={labelClassName}>Mark as read</span>
                </Button>
            )}
            {notification.is_archived ? (
                <Button leftIcon={<RotateCcw aria-hidden="true" className="size-4" />} loading={isPending} onClick={() => onRestore(notification)} size={size} variant="outline">
                    <span className={labelClassName}>Restore</span>
                </Button>
            ) : (
                <Button leftIcon={<Archive aria-hidden="true" className="size-4" />} loading={isPending} onClick={() => onArchive(notification)} size={size} variant="ghost">
                    <span className={labelClassName}>Archive</span>
                </Button>
            )}
            <Button leftIcon={<Trash2 aria-hidden="true" className="size-4" />} loading={isPending} onClick={() => onDelete(notification)} size={size} variant="danger">
                <span className={labelClassName}>Delete</span>
            </Button>
        </div>
    );
}
