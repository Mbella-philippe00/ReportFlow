import type { ReactNode } from 'react';

import { Card } from '@/components/ui';

export type PageHeaderProps = {
    actions?: ReactNode;
    description?: ReactNode;
    eyebrow?: ReactNode;
    title: ReactNode;
};

export function PageHeader({ actions, description, eyebrow, title }: PageHeaderProps) {
    return (
        <Card className="p-5">
            <div className="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div className="min-w-0">
                    {eyebrow && <p className="text-xs font-semibold uppercase tracking-wide text-primary">{eyebrow}</p>}
                    <h1 className="mt-1 text-2xl font-semibold tracking-tight text-surface-foreground">{title}</h1>
                    {description && <div className="mt-2 max-w-3xl text-sm leading-relaxed text-muted-foreground">{description}</div>}
                </div>
                {actions && <div className="flex shrink-0 flex-wrap items-center gap-2">{actions}</div>}
            </div>
        </Card>
    );
}
