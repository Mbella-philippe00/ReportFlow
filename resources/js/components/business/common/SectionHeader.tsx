import type { ReactNode } from 'react';

export type SectionHeaderProps = {
    actions?: ReactNode;
    description?: ReactNode;
    title: ReactNode;
};

export function SectionHeader({ actions, description, title }: SectionHeaderProps) {
    return (
        <header className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div className="min-w-0">
                <h2 className="text-lg font-semibold tracking-tight text-foreground">{title}</h2>
                {description && <div className="mt-1 text-sm leading-relaxed text-muted-foreground">{description}</div>}
            </div>
            {actions && <div className="flex shrink-0 flex-wrap items-center gap-2">{actions}</div>}
        </header>
    );
}
