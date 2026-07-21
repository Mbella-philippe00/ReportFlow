import { Bot, History, RefreshCw } from 'lucide-react';
import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';

import { NoPermission } from '@/components/business';
import { Badge, Button, Card, CardContent, CardDescription, CardHeader, CardTitle, EmptyState } from '@/components/ui';
import { appConfig } from '@/config/app';
import { useAuthStore } from '@/stores/auth.store';
import type { AiHistoryItem } from '@/types';

import { AiCardsSkeleton, AiDashboardMetrics, AiEmptyState, AiErrorState, AiHistoryList, AiPageShell, AiProviderList, AiResultCard, AiSectionSkeleton } from '../components';
import { useAiDashboardQuery, useAiHistoryQuery, useAiProvidersQuery } from '../hooks/useAi';
import { canViewAiDashboard } from '../utils/ai-utils';

export function AiDashboardPage() {
    const navigate = useNavigate();
    const user = useAuthStore((state) => state.user);
    const [selectedGeneration, setSelectedGeneration] = useState<AiHistoryItem | null>(null);
    const dashboardQuery = useAiDashboardQuery();
    const providersQuery = useAiProvidersQuery();
    const historyQuery = useAiHistoryQuery({ page: 1, per_page: 5, scope: 'mine' });

    useEffect(() => {
        document.title = `AI Dashboard - ${appConfig.name}`;
    }, []);

    if (!canViewAiDashboard(user)) {
        return (
            <AiPageShell description="The AI dashboard endpoint is restricted by backend authorization." title="AI Dashboard">
                <NoPermission
                    action={{ label: 'Open AI Assistant', onClick: () => navigate('/ai/assistant') }}
                    description="Managers and super-admins can view AI usage metrics. Report owners can still use report-level AI actions when allowed by the backend."
                    title="AI dashboard restricted"
                />
            </AiPageShell>
        );
    }

    return (
        <AiPageShell
            actions={<Button leftIcon={<RefreshCw aria-hidden="true" className="size-4" />} onClick={() => void dashboardQuery.refetch()} variant="outline">Refresh</Button>}
            description="Usage, providers, and recent AI generations from the ReportFlow AI REST API."
            title="AI Dashboard"
        >
            {dashboardQuery.isLoading ? (
                <AiCardsSkeleton count={4} />
            ) : dashboardQuery.isError ? (
                <AiErrorState error={dashboardQuery.error} onRetry={() => void dashboardQuery.refetch()} />
            ) : dashboardQuery.data ? (
                <AiDashboardMetrics dashboard={dashboardQuery.data.data} />
            ) : null}

            <div className="grid gap-6 xl:grid-cols-[minmax(0,1fr)_24rem]">
                <div className="grid gap-6">
                    <Card>
                        <CardHeader className="flex-row items-start justify-between gap-3">
                            <div>
                                <CardTitle>Available providers</CardTitle>
                                <CardDescription>Models and provider readiness reported by the backend.</CardDescription>
                            </div>
                            <Badge intent="primary">No keys exposed</Badge>
                        </CardHeader>
                        <CardContent>
                            {providersQuery.isLoading ? (
                                <AiSectionSkeleton />
                            ) : providersQuery.isError ? (
                                <AiErrorState error={providersQuery.error} onRetry={() => void providersQuery.refetch()} title="Unable to load providers" />
                            ) : providersQuery.data?.data.length ? (
                                <AiProviderList providers={providersQuery.data.data} />
                            ) : (
                                <AiEmptyState title="No providers returned" description="The providers endpoint returned an empty list." />
                            )}
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex-row items-start justify-between gap-3">
                            <div>
                                <CardTitle>Recent activity</CardTitle>
                                <CardDescription>Latest successful AI generations for your account.</CardDescription>
                            </div>
                            <History aria-hidden="true" className="size-5 text-primary" />
                        </CardHeader>
                        <CardContent>
                            {historyQuery.isLoading ? (
                                <AiSectionSkeleton />
                            ) : historyQuery.isError ? (
                                <AiErrorState error={historyQuery.error} onRetry={() => void historyQuery.refetch()} title="Unable to load recent AI history" />
                            ) : historyQuery.data?.data.length ? (
                                <AiHistoryList items={historyQuery.data.data} onSelect={setSelectedGeneration} />
                            ) : (
                                <EmptyState
                                    action={{ label: 'Open Assistant', onClick: () => navigate('/ai/assistant') }}
                                    icon={<Bot aria-hidden="true" className="size-10" />}
                                    title="No recent generations"
                                    description="Use the AI Assistant to create your first generation."
                                />
                            )}
                        </CardContent>
                    </Card>
                </div>

                <aside className="grid content-start gap-6">
                    <AiResultCard generation={selectedGeneration} title="Reopened generation" />
                    {!selectedGeneration && (
                        <Card>
                            <CardHeader>
                                <CardTitle>Result preview</CardTitle>
                                <CardDescription>Select a recent generation to reopen its full result.</CardDescription>
                            </CardHeader>
                        </Card>
                    )}
                </aside>
            </div>
        </AiPageShell>
    );
}
