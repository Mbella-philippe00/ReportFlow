import { Bell } from 'lucide-react';
import { useEffect, useId, useState } from 'react';

export function NotificationBell() {
    const [open, setOpen] = useState(false);
    const panelId = useId();

    useEffect(() => {
        if (!open) {
            return undefined;
        }

        const closeOnEscape = (event: KeyboardEvent) => {
            if (event.key === 'Escape') {
                setOpen(false);
            }
        };

        document.addEventListener('keydown', closeOnEscape);

        return () => document.removeEventListener('keydown', closeOnEscape);
    }, [open]);

    return (
        <div className="relative">
            <button
                aria-controls={open ? panelId : undefined}
                aria-expanded={open}
                aria-haspopup="dialog"
                aria-label="Open notifications"
                className="inline-flex size-10 items-center justify-center rounded-xl border bg-surface text-muted-foreground transition hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                onClick={() => setOpen((current) => !current)}
                type="button"
            >
                <Bell aria-hidden="true" className="size-5" />
            </button>
            {open && (
                <div
                    aria-label="Notifications"
                    className="absolute right-0 z-30 mt-3 w-72 rounded-2xl border bg-surface p-4 text-sm shadow-elevated"
                    id={panelId}
                    role="dialog"
                >
                    <p className="font-medium text-surface-foreground">Notifications</p>
                    <p className="mt-2 text-muted-foreground">Notification data will be injected by the notifications feature.</p>
                </div>
            )}
        </div>
    );
}

