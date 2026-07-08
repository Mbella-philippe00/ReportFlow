import { useMutation } from '@tanstack/react-query';

import { queryClient } from '@/providers/QueryProvider';
import { login, logout } from '@/services/auth.service';
import type { LoginCredentials } from '@/services/auth.service';
import { useAuthStore } from '@/stores/auth.store';

export const useLoginMutation = () => {
    const setSession = useAuthStore((state) => state.setSession);

    return useMutation({
        mutationFn: (credentials: LoginCredentials) => login(credentials),
        onSuccess: (session) => {
            setSession(session);
            void queryClient.invalidateQueries();
        },
    });
};

export const useLogoutMutation = () => {
    const clearSession = useAuthStore((state) => state.clearSession);

    return useMutation({
        mutationFn: () => logout(),
        onSettled: () => {
            clearSession();
            queryClient.clear();
        },
    });
};
