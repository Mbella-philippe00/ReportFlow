import { useMemo, useState } from 'react';

import type { AnalyticsFilters } from '@/types';

import { sanitizeAnalyticsFilters } from '../utils/analytics-utils';

export const defaultAnalyticsFilters: AnalyticsFilters = {
    granularity: 'weekly',
    period: 'last_30_days',
};

export const useAnalyticsFilters = (initialFilters: AnalyticsFilters = defaultAnalyticsFilters) => {
    const [filters, setFilters] = useState<AnalyticsFilters>(initialFilters);
    const queryFilters = useMemo(() => sanitizeAnalyticsFilters(filters), [filters]);
    const resetFilters = () => setFilters(initialFilters);

    return {
        filters,
        queryFilters,
        resetFilters,
        setFilters,
    };
};
