import { Command, Menu, Monitor, Moon, PanelLeft, Search, Sun } from 'lucide-react';

import { Breadcrumb } from '@/components/shell/Breadcrumb';
import { NotificationBell } from '@/components/shell/NotificationBell';
import { UserMenu } from '@/components/shell/UserMenu';
import { useThemeStore } from '@/stores/theme.store';
import { useUiStore } from '@/stores/ui.store';
import type { ThemeMode } from '@/types';

const nextThemeMode: Record<ThemeMode, ThemeMode> = {
    dark: 'system',
    light: 'dark',
    system: 'light',
};

const themeIcons = {
    dark: Moon,
    light: Sun,
    system: Monitor,
};

export function Topbar() {
    const mode = useThemeStore((state) => state.mode);
    const setMode = useThemeStore((state) => state.setMode);
    const setCommandPaletteOpen = useUiStore((state) => state.setCommandPaletteOpen);
    const toggleDesktopSidebar = useUiStore((state) => state.toggleDesktopSidebar);
    const toggleMobileSidebar = useUiStore((state) => state.toggleMobileSidebar);
    const ThemeIcon = themeIcons[mode];

    return (
        <header className="sticky top-0 z-20 border-b border-border/70 bg-white/80 shadow-[0_1px_0_rgb(255_255_255_/_0.75)] backdrop-blur-xl supports-[backdrop-filter]:bg-white/75 dark:bg-surface/80 dark:supports-[backdrop-filter]:bg-surface/75">
            <div className="flex h-20 items-center gap-3 px-4 sm:px-6 lg:px-8">
                <button
                    aria-label="Open mobile navigation"
                    className="inline-flex size-10 items-center justify-center rounded-2xl text-muted-foreground transition duration-200 hover:bg-slate-100 hover:text-foreground dark:hover:bg-muted/60 focus:outline-none focus:ring-2 focus:ring-primary lg:hidden"
                    onClick={toggleMobileSidebar}
                    type="button"
                >
                    <Menu aria-hidden="true" className="size-5" />
                </button>

                <button
                    aria-label="Toggle desktop navigation width"
                    className="hidden size-10 items-center justify-center rounded-2xl text-muted-foreground transition duration-200 hover:bg-slate-100 hover:text-foreground dark:hover:bg-muted/60 focus:outline-none focus:ring-2 focus:ring-primary lg:inline-flex"
                    onClick={toggleDesktopSidebar}
                    type="button"
                >
                    <PanelLeft aria-hidden="true" className="size-5" />
                </button>

                <Breadcrumb />

                <div className="ml-auto flex items-center gap-2">
                    <button
                        aria-label="Open command palette"
                        className="hidden items-center gap-2 rounded-2xl border border-border/70 bg-surface/90 px-4 py-2.5 text-sm font-medium text-muted-foreground shadow-soft transition duration-200 hover:border-primary/25 hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary md:inline-flex"
                        onClick={() => setCommandPaletteOpen(true)}
                        type="button"
                    >
                        <Search aria-hidden="true" className="size-4" />
                        <span>Search</span>
                        <kbd className="rounded-lg border border-border/70 bg-slate-50 px-2 py-1 text-[0.7rem] text-muted-foreground dark:bg-muted">
                            <Command aria-hidden="true" className="inline size-3" /> K
                        </kbd>
                    </button>

                    <button
                        aria-label={`Switch theme from ${mode} mode`}
                        className="inline-flex size-10 items-center justify-center rounded-2xl border border-border/70 bg-surface/90 text-muted-foreground shadow-soft transition duration-200 hover:border-primary/25 hover:text-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                        onClick={() => setMode(nextThemeMode[mode])}
                        type="button"
                    >
                        <ThemeIcon aria-hidden="true" className="size-5" />
                    </button>

                    <NotificationBell />
                    <UserMenu />
                </div>
            </div>
        </header>
    );
}

