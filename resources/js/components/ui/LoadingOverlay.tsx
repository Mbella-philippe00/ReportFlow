import type { ReactNode } from 'react';

import { Spinner } from '@/components/ui/Spinner';
import { cn } from '@/utils/cn';

export type LoadingOverlayProps = {
    children?: ReactNode;
    className?: string;
    label?: string;
    visible: boolean;
};

export function LoadingOverlay({ children, className, label = 'Loading content', visible }: LoadingOverlayProps) {
    return (
        <div className={cn('relative', className)}>
            {children}
            {visible && (
                <div className="absolute inset-0 z-20 flex items-center justify-center rounded-2xl bg-surface/75 backdrop-blur-sm" role="status">
                    <div className="flex items-center gap-3 rounded-xl border bg-surface px-4 py-3 shadow-soft">
                        <Spinner />
                        <span className="text-sm font-medium text-foreground">{label}</span>
                    </div>
                </div>
            )}
        </div>
    );
}
