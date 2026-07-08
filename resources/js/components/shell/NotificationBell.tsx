import { Bell } from 'lucide-react';
import { useEffect, useId, useRef, useState } from 'react';

import { NotificationBadge } from '@/components/business/notifications';
import { NotificationDropdown } from '@/features/notifications/components/NotificationDropdown';
import { useUnreadNotificationsCountQuery } from '@/features/notifications/hooks/useNotifications';

export function NotificationBell() {
    const [open, setOpen] = useState(false);
    const containerRef = useRef<HTMLDivElement | null>(null);
    const panelId = useId();
    const unreadCountQuery = useUnreadNotificationsCountQuery();
    const unreadCount = unreadCountQuery.data?.data.count ?? 0;

    useEffect(() => {
        if (!open) {
            return undefined;
        }

        const closeOnEscape = (event: KeyboardEvent) => {
            if (event.key === 'Escape') {
                setOpen(false);
            }
        };

        const closeOnOutsideClick = (event: MouseEvent) => {
            if (event.target instanceof Node && !containerRef.current?.contains(event.target)) {
                setOpen(false);
            }
        };

        document.addEventListener('keydown', closeOnEscape);
        document.addEventListener('mousedown', closeOnOutsideClick);

        return () => {
            document.removeEventListener('keydown', closeOnEscape);
            document.removeEventListener('mousedown', closeOnOutsideClick);
        };
    }, [open]);

    return (
        <div className="relative" ref={containerRef}>
            <button
                aria-controls={open ? panelId : undefined}
                aria-expanded={open}
                aria-haspopup="dialog"
                aria-label={unreadCount > 0 ? `Open notifications, ${unreadCount} unread` : 'Open notifications'}
                className="relative inline-flex size-10 items-center justify-center rounded-xl border bg-surface text-muted-foreground transition hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                onClick={() => setOpen((current) => !current)}
                type="button"
            >
                <Bell aria-hidden="true" className="size-5" />
                <span className="absolute -right-2 -top-2">
                    <NotificationBadge count={unreadCount} />
                </span>
            </button>
            {open && (
                <div
                    aria-label="Notifications"
                    className="absolute right-0 z-30 mt-3 max-h-[min(36rem,calc(100vh-6rem))] w-[min(24rem,calc(100vw-2rem))] overflow-auto rounded-2xl border bg-surface p-4 text-sm shadow-elevated"
                    id={panelId}
                    role="dialog"
                >
                    <NotificationDropdown onClose={() => setOpen(false)} />
                </div>
            )}
        </div>
    );
}
