import type { PropsWithChildren, ReactNode } from 'react';

import { cn } from '@/utils/cn';

type PageContainerProps = PropsWithChildren<{
    actions?: ReactNode;
    className?: string;
    description?: string;
    eyebrow?: string;
    title: string;
}>;

export function PageContainer({ actions, children, className, description, eyebrow, title }: PageContainerProps) {
    return (
        <section className={cn('mx-auto flex w-full max-w-7xl flex-1 flex-col gap-8 px-4 py-8 sm:px-6 lg:px-8', className)}>
            <header className="animate-premium-slide-up flex flex-col gap-4 rounded-[2rem] border border-border/70 bg-surface/90 p-6 shadow-elevated backdrop-blur sm:flex-row sm:items-start sm:justify-between">
                <div className="min-w-0">
                    {eyebrow && <p className="text-xs font-semibold uppercase tracking-[0.18em] text-primary">{eyebrow}</p>}
                    <h1 className="mt-2 font-display text-3xl font-semibold tracking-[-0.045em] text-surface-foreground">{title}</h1>
                    {description && <p className="mt-3 max-w-3xl text-sm leading-6 text-muted-foreground">{description}</p>}
                </div>
                {actions && <div className="flex w-full shrink-0 flex-wrap items-center gap-2 sm:w-auto sm:justify-end">{actions}</div>}
            </header>
            {children}
        </section>
    );
}

