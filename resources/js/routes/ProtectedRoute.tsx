import type { ReactNode } from 'react';
import { Navigate, Outlet, useLocation } from 'react-router-dom';

import { AppSplash } from '@/components/layout';
import { useAuthStore } from '@/stores/auth.store';

type RouteGuardProps = {
    children?: ReactNode;
};

function RouteLoadingState() {
    return <AppSplash />;
}

export function ProtectedRoute({ children }: RouteGuardProps) {
    const isAuthenticated = useAuthStore((state) => state.isAuthenticated);
    const status = useAuthStore((state) => state.status);
    const location = useLocation();

    if (status === 'checking' || status === 'idle') {
        return <RouteLoadingState />;
    }

    if (!isAuthenticated) {
        return <Navigate replace state={{ from: location }} to='/login' />;
    }

    return children ?? <Outlet />;
}
