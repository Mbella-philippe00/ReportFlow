import type { PropsWithChildren } from 'react';

import { PageContainer } from '@/components/layout/PageContainer';
import type { AnalyticsExportOptions, AnalyticsFilters } from '@/types';

import { AnalyticsExportAction } from './AnalyticsExportAction';
import { AnalyticsFiltersPanel } from './AnalyticsFiltersPanel';
import { AnalyticsNav } from './AnalyticsNav';

export type AnalyticsPageShellProps = PropsWithChildren<{
    description: string;
    exportOptions?: AnalyticsExportOptions;
    exportOptionsLoading?: boolean;
    filters: AnalyticsFilters;
    onFiltersChange: (filters: AnalyticsFilters) => void;
    onFiltersReset: () => void;
    showGranularity?: boolean;
    title: string;
}>;

export function AnalyticsPageShell({
    children,
    description,
    exportOptions,
    exportOptionsLoading = false,
    filters,
    onFiltersChange,
    onFiltersReset,
    showGranularity = false,
    title,
}: AnalyticsPageShellProps) {
    return (
        <PageContainer
            actions={<AnalyticsExportAction exportOptions={exportOptions} loading={exportOptionsLoading} />}
            description={description}
            eyebrow="Analytics"
            title={title}
        >
            <AnalyticsNav />
            <AnalyticsFiltersPanel filters={filters} onChange={onFiltersChange} onReset={onFiltersReset} showGranularity={showGranularity} />
            {children}
        </PageContainer>
    );
}
