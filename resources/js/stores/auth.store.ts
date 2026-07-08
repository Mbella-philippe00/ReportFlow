import { create } from 'zustand';

import { authStorage } from '@/lib/auth-storage';
import type { AuthStatus, AuthUser } from '@/types';

type AuthSession = {
    token: string;
    user: AuthUser;
};

type AuthState = {
    clearSession: () => void;
    isAuthenticated: boolean;
    setSession: (session: AuthSession) => void;
    setStatus: (status: AuthStatus) => void;
    status: AuthStatus;
    token: string | null;
    user: AuthUser | null;
};

const initialSession = authStorage.read();
const hasInitialSession = Boolean(initialSession.token && initialSession.user);

export const useAuthStore = create<AuthState>((set) => ({
    clearSession: () => {
        authStorage.clear();
        set({
            isAuthenticated: false,
            status: 'guest',
            token: null,
            user: null,
        });
    },
    isAuthenticated: hasInitialSession,
    setSession: (session) => {
        authStorage.write(session);
        set({
            isAuthenticated: true,
            status: 'authenticated',
            token: session.token,
            user: session.user,
        });
    },
    setStatus: (status) => set({ status }),
    status: hasInitialSession ? 'authenticated' : 'idle',
    token: initialSession.token,
    user: initialSession.user,
}));

