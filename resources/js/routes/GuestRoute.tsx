import type { ReactNode } from 'react';
import { Navigate, Outlet } from 'react-router-dom';

import { Spinner } from '@/components/ui';
import { useAuthStore } from '@/stores/auth.store';

type RouteGuardProps = {
    children?: ReactNode;
};

function RouteLoadingState() {
    return (
        <div className="grid gap-3 text-center text-sm text-muted-foreground">
            <span className="mx-auto"><Spinner size="sm" /></span>
            Restoring session?
        </div>
    );
}

export function GuestRoute({ children }: RouteGuardProps) {
    const isAuthenticated = useAuthStore((state) => state.isAuthenticated);
    const status = useAuthStore((state) => state.status);

    if (status === 'checking' || status === 'idle') {
        return <RouteLoadingState />;
    }

    if (isAuthenticated) {
        return <Navigate replace to="/dashboard" />;
    }

    return children ?? <Outlet />;
}
