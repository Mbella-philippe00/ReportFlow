import type { ReactNode } from 'react';

import { Card } from '@/components/ui';

export type DataToolbarProps = {
    actions?: ReactNode;
    filters?: ReactNode;
    search?: ReactNode;
};

export function DataToolbar({ actions, filters, search }: DataToolbarProps) {
    return (
        <Card className="p-4">
            <div className="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div className="flex min-w-0 flex-1 flex-col gap-3 md:flex-row md:items-end">
                    {search}
                    {filters}
                </div>
                {actions && <div className="flex shrink-0 flex-wrap items-center gap-2">{actions}</div>}
            </div>
        </Card>
    );
}
