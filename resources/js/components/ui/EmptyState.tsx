import type { ReactNode } from 'react';

import { Button } from '@/components/ui/Button';
import { cn } from '@/utils/cn';

export type EmptyStateProps = {
    action?: {
        label: string;
        onClick: () => void;
    };
    className?: string;
    description?: ReactNode;
    icon?: ReactNode;
    title: ReactNode;
};

export function EmptyState({ action, className, description, icon, title }: EmptyStateProps) {
    return (
        <section className={cn('flex min-h-64 flex-col items-center justify-center rounded-2xl border border-dashed bg-surface p-8 text-center', className)}>
            {icon && <div className="mb-4 text-muted-foreground">{icon}</div>}
            <h2 className="text-lg font-semibold text-surface-foreground">{title}</h2>
            {description && <div className="mt-2 max-w-md text-sm leading-relaxed text-muted-foreground">{description}</div>}
            {action && <Button className="mt-5" onClick={action.onClick}>{action.label}</Button>}
        </section>
    );
}
