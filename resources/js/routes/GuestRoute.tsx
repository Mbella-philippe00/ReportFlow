import type { ReactNode } from 'react';
import { Navigate, Outlet } from 'react-router-dom';

import { useAuthStore } from '@/stores/auth.store';

type RouteGuardProps = {
    children?: ReactNode;
};

export function GuestRoute({ children }: RouteGuardProps) {
    const isAuthenticated = useAuthStore((state) => state.isAuthenticated);

    if (isAuthenticated) {
        return <Navigate replace to="/dashboard" />;
    }

    return children ?? <Outlet />;
}
