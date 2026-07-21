import { useIsFetching, useIsMutating } from '@tanstack/react-query';
import { Outlet } from 'react-router-dom';

import { GlobalLoadingBar } from '@/components/ui';
import { CommandPalette } from '@/components/shell/CommandPalette';
import { Footer } from '@/components/shell/Footer';
import { Sidebar } from '@/components/shell/Sidebar';
import { Topbar } from '@/components/shell/Topbar';
import { useUiStore } from '@/stores/ui.store';
import { cn } from '@/utils/cn';

export function AppLayout() {
    const desktopSidebarCollapsed = useUiStore((state) => state.desktopSidebarCollapsed);
    const activeRequests = useIsFetching() + useIsMutating();

    return (
        <div className="min-h-screen bg-background text-foreground">
            <GlobalLoadingBar active={activeRequests > 0} />
            <a
                className="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-xl focus:bg-primary focus:px-4 focus:py-2 focus:text-sm focus:font-medium focus:text-primary-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                href="#main-content"
            >
                Skip to main content
            </a>
            <Sidebar />
            <div className={cn('flex min-h-screen flex-col transition-[padding] duration-200 lg:pl-72', desktopSidebarCollapsed && 'lg:pl-20')}>
                <Topbar />
                <main className="flex flex-1 flex-col outline-none animate-premium-fade" id="main-content" tabIndex={-1}>
                    <Outlet />
                </main>
                <Footer />
            </div>
            <CommandPalette />
        </div>
    );
}

