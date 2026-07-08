import type { PropsWithChildren } from 'react';

import { AuthProvider } from '@/providers/AuthProvider';
import { QueryProvider } from '@/providers/QueryProvider';
import { ThemeProvider } from '@/providers/ThemeProvider';
import { ToastProvider } from '@/providers/ToastProvider';

export function AppProviders({ children }: PropsWithChildren) {
    return (
        <QueryProvider>
            <ThemeProvider>
                <AuthProvider>
                    <ToastProvider>{children}</ToastProvider>
                </AuthProvider>
            </ThemeProvider>
        </QueryProvider>
    );
}
