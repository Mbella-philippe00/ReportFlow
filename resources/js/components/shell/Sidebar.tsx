import {
    Activity,
    Bell,
    FileText,
    GitPullRequest,
    LayoutDashboard,
    Settings,
    Sparkles,
    Users,
    X,
} from 'lucide-react';
import type { LucideIcon } from 'lucide-react';
import { useEffect } from 'react';
import { NavLink } from 'react-router-dom';

import { ApplicationLogo } from '@/components/shell/ApplicationLogo';
import { navigationItems } from '@/config/navigation';
import { useUiStore } from '@/stores/ui.store';
import { cn } from '@/utils/cn';

const navigationIconMap: Record<string, LucideIcon> = {
    Activity,
    Bell,
    FileText,
    GitPullRequest,
    LayoutDashboard,
    Settings,
    Sparkles,
    Users,
};

type NavigationListProps = {
    compact?: boolean;
    onNavigate?: () => void;
};

function NavigationList({ compact = false, onNavigate }: NavigationListProps) {
    return (
        <nav aria-label="Primary navigation" className="flex flex-1 flex-col gap-1 px-3 py-4">
            {navigationItems.map((item) => {
                const Icon = navigationIconMap[item.icon] ?? LayoutDashboard;

                return (
                    <NavLink
                        className={({ isActive }) =>
                            cn(
                                'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium outline-none transition focus:ring-2 focus:ring-primary',
                                compact && 'justify-center px-2',
                                isActive
                                    ? 'bg-primary text-primary-foreground shadow-soft'
                                    : 'text-muted-foreground hover:bg-muted hover:text-foreground',
                            )
                        }
                        key={item.href}
                        onClick={onNavigate}
                        title={compact ? item.label : undefined}
                        to={item.href}
                    >
                        <Icon aria-hidden="true" className="size-5 shrink-0" />
                        <span className={cn('truncate', compact && 'sr-only')}>{item.label}</span>
                    </NavLink>
                );
            })}
        </nav>
    );
}

export function Sidebar() {
    const desktopSidebarCollapsed = useUiStore((state) => state.desktopSidebarCollapsed);
    const mobileSidebarOpen = useUiStore((state) => state.mobileSidebarOpen);
    const setMobileSidebarOpen = useUiStore((state) => state.setMobileSidebarOpen);

    useEffect(() => {
        if (!mobileSidebarOpen) {
            return undefined;
        }

        const closeOnEscape = (event: KeyboardEvent) => {
            if (event.key === 'Escape') {
                setMobileSidebarOpen(false);
            }
        };

        document.addEventListener('keydown', closeOnEscape);

        return () => document.removeEventListener('keydown', closeOnEscape);
    }, [mobileSidebarOpen, setMobileSidebarOpen]);

    return (
        <>
            <aside
                className={cn(
                    'fixed inset-y-0 left-0 z-30 hidden flex-col border-r bg-surface transition-[width] duration-200 lg:flex',
                    desktopSidebarCollapsed ? 'w-20' : 'w-72',
                )}
            >
                <div className="flex h-16 items-center border-b px-4">
                    <ApplicationLogo compact={desktopSidebarCollapsed} />
                </div>
                <NavigationList compact={desktopSidebarCollapsed} />
            </aside>

            {mobileSidebarOpen && (
                <div className="fixed inset-0 z-50 lg:hidden" role="dialog" aria-modal="true" aria-label="Mobile navigation">
                    <button
                        aria-label="Close mobile navigation"
                        className="absolute inset-0 bg-slate-950/50 backdrop-blur-sm"
                        onClick={() => setMobileSidebarOpen(false)}
                        type="button"
                    />
                    <aside className="relative flex h-full w-80 max-w-[85vw] flex-col border-r bg-surface shadow-elevated">
                        <div className="flex h-16 items-center justify-between border-b px-4">
                            <ApplicationLogo />
                            <button
                                aria-label="Close mobile navigation"
                                className="inline-flex size-10 items-center justify-center rounded-xl text-muted-foreground transition hover:bg-muted hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                                onClick={() => setMobileSidebarOpen(false)}
                                type="button"
                            >
                                <X aria-hidden="true" className="size-5" />
                            </button>
                        </div>
                        <NavigationList onNavigate={() => setMobileSidebarOpen(false)} />
                    </aside>
                </div>
            )}
        </>
    );
}

