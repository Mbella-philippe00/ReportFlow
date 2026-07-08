import { Badge } from '@/components/ui';

export type NotificationBadgeProps = {
    count: number;
    max?: number;
    showZero?: boolean;
};

export function NotificationBadge({ count, max = 99, showZero = false }: NotificationBadgeProps) {
    if (count <= 0 && !showZero) {
        return null;
    }

    const label = count > max ? `${max}+` : String(count);

    return (
        <Badge aria-label={`${count} unread notifications`} intent={count > 0 ? 'danger' : 'neutral'}>
            {label}
        </Badge>
    );
}
