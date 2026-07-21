import { createContext, useCallback, useContext, useRef, useState } from 'react';
import type { PropsWithChildren } from 'react';

import { Toast, ToastViewport } from '@/components/ui';
import { logger } from '@/lib/logger';

export type ToastIntent = 'error' | 'info' | 'success' | 'warning';

export type ToastMessage = {
    description?: string;
    intent: ToastIntent;
    title: string;
};

type ToastRecord = ToastMessage & {
    id: number;
};

type ToastContextValue = {
    notify: (message: ToastMessage) => void;
};

const ToastContext = createContext<ToastContextValue | null>(null);

const toastDuration = 5000;
const intentMap: Record<ToastIntent, 'danger' | 'info' | 'success' | 'warning'> = {
    error: 'danger',
    info: 'info',
    success: 'success',
    warning: 'warning',
};

export function ToastProvider({ children }: PropsWithChildren) {
    const nextId = useRef(1);
    const [toasts, setToasts] = useState<ToastRecord[]>([]);

    const dismiss = useCallback((id: number) => {
        setToasts((current) => current.filter((toast) => toast.id !== id));
    }, []);

    const notify = useCallback((message: ToastMessage) => {
        const id = nextId.current;
        nextId.current += 1;

        logger.info('Toast notification', message);
        setToasts((current) => [...current.slice(-3), { ...message, id }]);
        window.setTimeout(() => dismiss(id), toastDuration);
    }, [dismiss]);

    return (
        <ToastContext.Provider value={{ notify }}>
            {children}
            <ToastViewport>
                {toasts.map((toast) => (
                    <Toast
                        description={toast.description}
                        intent={intentMap[toast.intent]}
                        key={toast.id}
                        onClose={() => dismiss(toast.id)}
                        title={toast.title}
                    />
                ))}
            </ToastViewport>
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
