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
            <div className="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                <div className="flex min-w-0 flex-1 flex-col gap-3 lg:flex-row lg:items-end">
                    {search}
                    {filters}
                </div>
                {actions && <div className="flex w-full shrink-0 flex-wrap items-center gap-2 xl:w-auto xl:justify-end">{actions}</div>}
            </div>
        </Card>
    );
}
