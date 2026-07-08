import { createContext, useContext } from 'react';
import type { PropsWithChildren } from 'react';

import { useAuthStore } from '@/stores/auth.store';
import type { AuthStatus, AuthUser } from '@/types';

type AuthContextValue = {
    isAuthenticated: boolean;
    status: AuthStatus;
    user: AuthUser | null;
};

const AuthContext = createContext<AuthContextValue | null>(null);

export function AuthProvider({ children }: PropsWithChildren) {
    const isAuthenticated = useAuthStore((state) => state.isAuthenticated);
    const status = useAuthStore((state) => state.status);
    const user = useAuthStore((state) => state.user);

    return (
        <AuthContext.Provider value={{ isAuthenticated, status, user }}>
            {children}
        </AuthContext.Provider>
    );
}

export const useAuthContext = (): AuthContextValue => {
    const context = useContext(AuthContext);

    if (!context) {
        throw new Error('useAuthContext must be used within AuthProvider.');
    }

    return context;
};
