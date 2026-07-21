import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import type { PropsWithChildren } from 'react';

import { isRetryableError } from '@/lib/errors';

export const queryClient = new QueryClient({
    defaultOptions: {
        mutations: {
            retry: false,
        },
        queries: {
            refetchOnWindowFocus: false,
            retry: (failureCount, error) => failureCount < 1 && isRetryableError(error),
            staleTime: 30_000,
        },
    },
});

export function QueryProvider({ children }: PropsWithChildren) {
    return <QueryClientProvider client={queryClient}>{children}</QueryClientProvider>;
}

