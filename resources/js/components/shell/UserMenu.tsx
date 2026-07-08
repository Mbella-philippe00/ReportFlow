import { ChevronDown, LogOut, Settings, User } from 'lucide-react';
import { useEffect, useId, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';

import { useLogoutMutation } from '@/features/auth/hooks/useAuth';
import { useToast } from '@/providers/ToastProvider';
import { useAuthStore } from '@/stores/auth.store';

export function UserMenu() {
    const navigate = useNavigate();
    const { notify } = useToast();
    const logoutMutation = useLogoutMutation();
    const [open, setOpen] = useState(false);
    const menuId = useId();
    const user = useAuthStore((state) => state.user);
    const displayName = user?.name ?? 'Account';
    const displayEmail = user?.email ?? 'Session not loaded';

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

    const signOut = () => {
        logoutMutation.mutate(undefined, {
            onSettled: () => {
                notify({ intent: 'success', title: 'Signed out' });
                setOpen(false);
                navigate('/login', { replace: true });
            },
        });
    };

    return (
        <div className="relative">
            <button
                aria-controls={open ? menuId : undefined}
                aria-expanded={open}
                aria-haspopup="menu"
                className="inline-flex items-center gap-2 rounded-xl border bg-surface px-2.5 py-2 text-left transition hover:bg-muted focus:outline-none focus:ring-2 focus:ring-primary"
                onClick={() => setOpen((current) => !current)}
                type="button"
            >
                <span className="inline-flex size-8 items-center justify-center rounded-lg bg-muted text-sm font-semibold text-foreground" aria-hidden="true">
                    <User className="size-4" />
                </span>
                <span className="hidden min-w-0 sm:block">
                    <span className="block truncate text-sm font-medium text-foreground">{displayName}</span>
                    <span className="block truncate text-xs text-muted-foreground">{displayEmail}</span>
                </span>
                <ChevronDown aria-hidden="true" className="hidden size-4 text-muted-foreground sm:block" />
            </button>
            {open && (
                <div
                    className="absolute right-0 z-30 mt-3 w-64 overflow-hidden rounded-2xl border bg-surface shadow-elevated"
                    id={menuId}
                    role="menu"
                >
                    <div className="border-b px-4 py-3">
                        <p className="truncate text-sm font-medium text-surface-foreground">{displayName}</p>
                        <p className="truncate text-xs text-muted-foreground">{displayEmail}</p>
                    </div>
                    <div className="p-1">
                        <Link
                            className="flex items-center gap-2 rounded-xl px-3 py-2 text-sm text-muted-foreground transition hover:bg-muted hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                            onClick={() => setOpen(false)}
                            role="menuitem"
                            to="/profile"
                        >
                            <User aria-hidden="true" className="size-4" />
                            Profile
                        </Link>
                        <Link
                            className="flex items-center gap-2 rounded-xl px-3 py-2 text-sm text-muted-foreground transition hover:bg-muted hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                            onClick={() => setOpen(false)}
                            role="menuitem"
                            to="/settings"
                        >
                            <Settings aria-hidden="true" className="size-4" />
                            Settings
                        </Link>
                    </div>
                    <div className="border-t p-1">
                        <button
                            className="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-left text-sm text-muted-foreground transition hover:bg-muted hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary disabled:cursor-not-allowed disabled:opacity-60"
                            disabled={logoutMutation.isPending}
                            onClick={signOut}
                            role="menuitem"
                            type="button"
                        >
                            <LogOut aria-hidden="true" className="size-4" />
                            {logoutMutation.isPending ? 'Signing out?' : 'Sign out'}
                        </button>
                    </div>
                </div>
            )}
        </div>
    );
}
