import { logger } from '@/lib/logger';

export type AnalyticsEvent = {
    name: string;
    properties?: Record<string, boolean | number | string | null>;
};

export const analytics = Object.freeze({
    pageView: (path: string) => {
        logger.debug('Analytics page view', { path });
    },
    track: (event: AnalyticsEvent) => {
        logger.debug('Analytics event', { event });
    },
});
