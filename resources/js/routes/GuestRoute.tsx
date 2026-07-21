import type { ReactNode } from 'react';
import { Navigate, Outlet } from 'react-router-dom';

import { AppSplash } from '@/components/layout';
import { useAuthStore } from '@/stores/auth.store';

type RouteGuardProps = {
    children?: ReactNode;
};

function RouteLoadingState() {
    return <AppSplash />;
}

export function GuestRoute({ children }: RouteGuardProps) {
    const isAuthenticated = useAuthStore((state) => state.isAuthenticated);
    const status = useAuthStore((state) => state.status);

    if (status === 'checking' || status === 'idle') {
        return <RouteLoadingState />;
    }

    if (isAuthenticated) {
        return <Navigate replace to='/dashboard' />;
    }

    return children ?? <Outlet />;
}
