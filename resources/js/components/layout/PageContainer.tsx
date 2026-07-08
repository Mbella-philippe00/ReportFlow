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
        <section className={cn('mx-auto flex w-full max-w-7xl flex-1 flex-col gap-6 px-4 py-6 sm:px-6 lg:px-8', className)}>
            <header className="flex flex-col gap-4 rounded-2xl border bg-surface p-5 shadow-soft sm:flex-row sm:items-start sm:justify-between">
                <div className="min-w-0">
                    {eyebrow && <p className="text-xs font-semibold uppercase tracking-wide text-primary">{eyebrow}</p>}
                    <h1 className="mt-1 text-2xl font-semibold tracking-tight text-surface-foreground">{title}</h1>
                    {description && <p className="mt-2 max-w-3xl text-sm leading-relaxed text-muted-foreground">{description}</p>}
                </div>
                {actions && <div className="flex shrink-0 items-center gap-2">{actions}</div>}
            </header>
            {children}
        </section>
    );
}

