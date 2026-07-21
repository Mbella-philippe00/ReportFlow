import { AlertTriangle, Bot } from 'lucide-react';

import { Alert, EmptyState, Skeleton } from '@/components/ui';
import { getErrorMessage } from '@/lib/errors';

export function AiCardsSkeleton({ count = 3 }: { count?: number }) {
    return (
        <div className="grid gap-4 md:grid-cols-3">
            {Array.from({ length: count }).map((_, index) => (
                <Skeleton className="h-32" key={index} />
            ))}
        </div>
    );
}

export function AiSectionSkeleton() {
    return <Skeleton className="h-72" />;
}

export function AiErrorState({ error, onRetry, title = 'Unable to load AI data' }: { error: unknown; onRetry?: () => void; title?: string }) {
    return (
        <div className="grid gap-4">
            <Alert intent="danger" title={title} description={getErrorMessage(error)} icon={<AlertTriangle aria-hidden="true" className="size-5" />} />
            {onRetry && (
                <EmptyState
                    action={{ label: 'Retry', onClick: onRetry }}
                    icon={<Bot aria-hidden="true" className="size-10" />}
                    title="AI data unavailable"
                    description="Retry the request, or verify that your role and provider configuration allow this AI endpoint."
                />
            )}
        </div>
    );
}

export function AiEmptyState({ description = 'AI generations will appear after using the report assistant.', title = 'No AI data yet' }: { description?: string; title?: string }) {
    return <EmptyState icon={<Bot aria-hidden="true" className="size-10" />} title={title} description={description} />;
}
