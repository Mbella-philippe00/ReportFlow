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
        <nav aria-label="Primary navigation" className="flex flex-1 flex-col gap-2 px-4 py-6">
            {navigationItems.map((item) => {
                const Icon = navigationIconMap[item.icon] ?? LayoutDashboard;

                return (
                    <NavLink
                        className={({ isActive }) =>
                            cn(
                                'group flex items-center gap-3 rounded-2xl px-3.5 py-3 text-sm font-semibold outline-none transition duration-200 focus:ring-2 focus:ring-primary',
                                compact && 'justify-center px-2',
                                isActive
                                    ? 'border border-primary/15 bg-blue-50 text-primary shadow-soft dark:bg-blue-950/40'
                                    : 'text-muted-foreground hover:bg-slate-100 hover:text-foreground dark:hover:bg-muted/60',
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
                    'fixed inset-y-0 left-0 z-30 hidden flex-col border-r border-border/70 bg-white/90 shadow-soft backdrop-blur-xl transition-[width] duration-200 lg:flex dark:bg-surface/90',
                    desktopSidebarCollapsed ? 'w-20' : 'w-72',
                )}
            >
                <div className="flex h-20 items-center border-b border-border/70 px-5">
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
                    <aside className="relative flex h-full w-80 max-w-[85vw] flex-col border-r border-border/70 bg-surface/95 shadow-premium backdrop-blur-xl">
                        <div className="flex h-20 items-center justify-between border-b border-border/70 px-5">
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

