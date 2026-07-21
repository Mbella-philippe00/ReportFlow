import { RotateCcw } from 'lucide-react';

import { Button, Card, Input, Select } from '@/components/ui';
import type { AnalyticsFilters, AnalyticsGranularity, AnalyticsPeriod, ReportStatusValue } from '@/types';

import { analyticsGranularityOptions, analyticsPeriodOptions, analyticsStatusOptions } from '../utils/analytics-utils';

export type AnalyticsFiltersPanelProps = {
    filters: AnalyticsFilters;
    onChange: (filters: AnalyticsFilters) => void;
    onReset: () => void;
    showGranularity?: boolean;
};

export function AnalyticsFiltersPanel({ filters, onChange, onReset, showGranularity = false }: AnalyticsFiltersPanelProps) {
    const updateFilter = (patch: AnalyticsFilters) => onChange({ ...filters, ...patch });
    const period = filters.period ?? 'last_30_days';

    return (
        <Card className="p-4">
            <div className="grid gap-4 lg:grid-cols-[1fr_auto] lg:items-end">
                <div className="grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
                    <Select
                        label="Period"
                        onChange={(event) => updateFilter({ period: event.target.value as AnalyticsPeriod })}
                        options={analyticsPeriodOptions}
                        value={period}
                    />
                    <Input
                        label="Department"
                        onChange={(event) => updateFilter({ department: event.target.value })}
                        placeholder="All departments"
                        value={filters.department ?? ''}
                    />
                    <Input
                        inputMode="numeric"
                        label="Employee ID"
                        min={1}
                        onChange={(event) => updateFilter({ employee: event.target.value })}
                        placeholder="All employees"
                        type="number"
                        value={filters.employee ?? ''}
                    />
                    <Select
                        label="Status"
                        onChange={(event) => updateFilter({ status: event.target.value as '' | ReportStatusValue })}
                        options={analyticsStatusOptions}
                        value={filters.status ?? ''}
                    />
                    {showGranularity && (
                        <Select
                            label="Trend view"
                            onChange={(event) => updateFilter({ granularity: event.target.value as AnalyticsGranularity })}
                            options={analyticsGranularityOptions}
                            value={filters.granularity ?? 'weekly'}
                        />
                    )}
                    {period === 'custom' && (
                        <>
                            <Input label="From" onChange={(event) => updateFilter({ from: event.target.value })} type="date" value={filters.from ?? ''} />
                            <Input label="To" onChange={(event) => updateFilter({ to: event.target.value })} type="date" value={filters.to ?? ''} />
                        </>
                    )}
                </div>
                <Button leftIcon={<RotateCcw aria-hidden="true" className="size-4" />} onClick={onReset} variant="outline">
                    Reset filters
                </Button>
            </div>
        </Card>
    );
}
