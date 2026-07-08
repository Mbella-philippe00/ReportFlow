import { createContext, useContext, useEffect } from 'react';
import type { PropsWithChildren } from 'react';

import { authStorageKey } from '@/lib/auth-storage';
import { getCurrentUser } from '@/services/auth.service';
import { useAuthStore } from '@/stores/auth.store';
import type { AuthStatus, AuthUser } from '@/types';

type AuthContextValue = {
    isAuthenticated: boolean;
    status: AuthStatus;
    user: AuthUser | null;
};

const AuthContext = createContext<AuthContextValue | null>(null);

export function AuthProvider({ children }: PropsWithChildren) {
    const clearSession = useAuthStore((state) => state.clearSession);
    const isAuthenticated = useAuthStore((state) => state.isAuthenticated);
    const setSession = useAuthStore((state) => state.setSession);
    const setStatus = useAuthStore((state) => state.setStatus);
    const status = useAuthStore((state) => state.status);
    const token = useAuthStore((state) => state.token);
    const user = useAuthStore((state) => state.user);

    useEffect(() => {
        if (!token) {
            setStatus('guest');
            return undefined;
        }

        const controller = new AbortController();
        setStatus('checking');

        getCurrentUser(controller.signal)
            .then((currentUser) => {
                setSession({ token, user: currentUser });
            })
            .catch((error: unknown) => {
                if (error instanceof DOMException && error.name === 'AbortError') {
                    return;
                }

                clearSession();
            });

        return () => controller.abort();
    }, [clearSession, setSession, setStatus, token]);

    useEffect(() => {
        const syncSessionAcrossTabs = (event: StorageEvent) => {
            if (event.key !== authStorageKey) {
                return;
            }

            if (!event.newValue) {
                clearSession();
            }
        };

        window.addEventListener('storage', syncSessionAcrossTabs);

        return () => window.removeEventListener('storage', syncSessionAcrossTabs);
    }, [clearSession]);

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
