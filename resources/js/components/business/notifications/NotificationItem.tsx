import type { ReactNode } from 'react';

import { Badge } from '@/components/ui';
import { cn } from '@/utils/cn';

export type NotificationItemProps = {
    actions?: ReactNode;
    className?: string;
    description?: ReactNode;
    icon?: ReactNode;
    onSelect?: () => void;
    time?: ReactNode;
    title: ReactNode;
    unread?: boolean;
};

export function NotificationItem({ actions, className, description, icon, onSelect, time, title, unread = false }: NotificationItemProps) {
    const content = (
        <>
            {icon && <span className="rounded-xl bg-muted p-2 text-muted-foreground">{icon}</span>}
            <span className="min-w-0 flex-1 text-left">
                <span className="flex items-center gap-2">
                    <span className="truncate text-sm font-medium text-foreground">{title}</span>
                    {unread && <Badge intent="primary">New</Badge>}
                </span>
                {description && <span className="mt-1 block text-sm text-muted-foreground">{description}</span>}
                {time && <span className="mt-1 block text-xs text-muted-foreground">{time}</span>}
            </span>
            {actions}
        </>
    );

    if (onSelect) {
        return (
            <button className={cn('flex w-full items-start gap-3 rounded-2xl border bg-surface p-3 transition hover:bg-muted/60 focus:outline-none focus:ring-2 focus:ring-primary', unread && 'border-primary/40', className)} onClick={onSelect} type="button">
                {content}
            </button>
        );
    }

    return <article className={cn('flex items-start gap-3 rounded-2xl border bg-surface p-3', unread && 'border-primary/40', className)}>{content}</article>;
}
