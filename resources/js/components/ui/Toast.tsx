import { X } from 'lucide-react';
import type { ReactNode } from 'react';

import { IconButton } from '@/components/ui/IconButton';
import { cn } from '@/utils/cn';

export type ToastIntent = 'danger' | 'info' | 'success' | 'warning';

const toastIntentClasses: Record<ToastIntent, string> = {
    danger: 'border-danger/30',
    info: 'border-primary/30',
    success: 'border-success/30',
    warning: 'border-warning/30',
};

export type ToastProps = {
    action?: ReactNode;
    className?: string;
    description?: ReactNode;
    intent?: ToastIntent;
    onClose?: () => void;
    title: ReactNode;
};

export function Toast({ action, className, description, intent = 'info', onClose, title }: ToastProps) {
    return (
        <div className={cn('flex w-full max-w-sm items-start gap-3 rounded-2xl border bg-surface p-4 text-sm text-surface-foreground shadow-elevated', toastIntentClasses[intent], className)} role={intent === 'danger' ? 'alert' : 'status'}>
            <div className="min-w-0 flex-1">
                <p className="font-semibold">{title}</p>
                {description && <div className="mt-1 text-muted-foreground">{description}</div>}
                {action && <div className="mt-3">{action}</div>}
            </div>
            {onClose && <IconButton aria-label="Close notification" icon={<X aria-hidden="true" className="size-4" />} onClick={onClose} size="sm" />}
        </div>
    );
}

export type ToastViewportProps = {
    children?: ReactNode;
};

export function ToastViewport({ children }: ToastViewportProps) {
    return (
        <div aria-live="polite" aria-relevant="additions text" className="fixed right-4 top-4 z-50 grid gap-3">
            {children}
        </div>
    );
}
