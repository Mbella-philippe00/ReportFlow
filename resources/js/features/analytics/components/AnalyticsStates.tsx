import { AlertCircle, BarChart3, RefreshCw } from 'lucide-react';

import { Alert, Button, Card, CardContent, CardHeader, EmptyState, Skeleton } from '@/components/ui';

import { getAnalyticsErrorMessage } from '../utils/analytics-utils';

export function AnalyticsErrorState({ error, onRetry, title = 'Unable to load analytics' }: { error: unknown; onRetry?: () => void; title?: string }) {
    return (
        <Alert
            description={
                <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <span>{getAnalyticsErrorMessage(error)}</span>
                    {onRetry && (
                        <Button leftIcon={<RefreshCw aria-hidden="true" className="size-4" />} onClick={onRetry} size="sm" variant="outline">
                            Retry
                        </Button>
                    )}
                </div>
            }
            icon={<AlertCircle aria-hidden="true" className="size-5" />}
            intent="danger"
            title={title}
        />
    );
}

export function AnalyticsEmptyState({ description = 'Analytics will appear when matching backend data exists.', title = 'No analytics data' }: { description?: string; title?: string }) {
    return <EmptyState description={description} icon={<BarChart3 aria-hidden="true" className="size-10" />} title={title} />;
}

export function AnalyticsCardsSkeleton({ count = 4 }: { count?: number }) {
    return (
        <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            {Array.from({ length: count }, (_, index) => (
                <Card key={index}>
                    <CardHeader>
                        <Skeleton className="h-4 w-28" />
                        <Skeleton className="mt-3 h-8 w-20" />
                    </CardHeader>
                    <CardContent>
                        <Skeleton className="h-4 w-full" />
                    </CardContent>
                </Card>
            ))}
        </div>
    );
}

export function AnalyticsSectionSkeleton() {
    return (
        <Card>
            <CardHeader>
                <Skeleton className="h-5 w-44" />
                <Skeleton className="h-4 w-72 max-w-full" />
            </CardHeader>
            <CardContent className="grid gap-3">
                <Skeleton className="h-52 w-full" />
                <Skeleton className="h-4 w-3/4" />
            </CardContent>
        </Card>
    );
}
