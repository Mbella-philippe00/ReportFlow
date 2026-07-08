import { createContext, useCallback, useContext } from 'react';
import type { PropsWithChildren } from 'react';

import { logger } from '@/lib/logger';

export type ToastIntent = 'error' | 'info' | 'success' | 'warning';

export type ToastMessage = {
    description?: string;
    intent: ToastIntent;
    title: string;
};

type ToastContextValue = {
    notify: (message: ToastMessage) => void;
};

const ToastContext = createContext<ToastContextValue | null>(null);

export function ToastProvider({ children }: PropsWithChildren) {
    const notify = useCallback((message: ToastMessage) => {
        logger.info('Toast notification', message);
    }, []);

    return (
        <ToastContext.Provider value={{ notify }}>
            {children}
            <div aria-live="polite" aria-relevant="additions text" id="toast-root" />
        </ToastContext.Provider>
    );
}

export const useToast = (): ToastContextValue => {
    const context = useContext(ToastContext);

    if (!context) {
        throw new Error('useToast must be used within ToastProvider.');
    }

    return context;
};
