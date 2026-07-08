import type { ReactNode } from 'react';
import { Navigate, Outlet, useLocation } from 'react-router-dom';

import { Spinner } from '@/components/ui';
import { useAuthStore } from '@/stores/auth.store';

type RouteGuardProps = {
    children?: ReactNode;
};

function RouteLoadingState() {
    return (
        <div className="flex min-h-screen items-center justify-center bg-background text-foreground">
            <div className="flex items-center gap-3 rounded-2xl border bg-surface px-4 py-3 text-sm text-muted-foreground shadow-soft">
                <Spinner size="sm" />
                Restoring session?
            </div>
        </div>
    );
}

export function ProtectedRoute({ children }: RouteGuardProps) {
    const isAuthenticated = useAuthStore((state) => state.isAuthenticated);
    const status = useAuthStore((state) => state.status);
    const location = useLocation();

    if (status === 'checking' || status === 'idle') {
        return <RouteLoadingState />;
    }

    if (!isAuthenticated) {
        return <Navigate replace state={{ from: location }} to="/login" />;
    }

    return children ?? <Outlet />;
}
