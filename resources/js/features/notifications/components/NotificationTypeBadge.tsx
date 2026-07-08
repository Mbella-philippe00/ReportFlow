import { Badge } from '@/components/ui';
import type { NotificationType } from '@/types';

import { notificationTypeMeta } from '../utils/notification-utils';

export type NotificationTypeBadgeProps = {
    type: NotificationType;
};

export function NotificationTypeBadge({ type }: NotificationTypeBadgeProps) {
    const meta = notificationTypeMeta[type];

    return <Badge intent={meta.intent}>{meta.label}</Badge>;
}
