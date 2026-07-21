import { History, RefreshCw } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';

import { Button, Card, CardContent, CardDescription, CardHeader, CardTitle, EmptyState, Input, Select } from '@/components/ui';
import { appConfig } from '@/config/app';
import { useAuthStore } from '@/stores/auth.store';
import type { AiAction, AiHistoryFilters, AiHistoryItem } from '@/types';

import { AiEmptyState, AiErrorState, AiHistoryList, AiPageShell, AiResultCard, AiSectionSkeleton } from '../components';
import { useAiHistoryQuery } from '../hooks/useAi';
import { aiActionOptions, aiHistoryScopeOptions, canViewAiDashboard } from '../utils/ai-utils';

export function AiHistoryPage() {
    const user = useAuthStore((state) => state.user);
    const [action, setAction] = useState<AiAction | ''>('');
    const [page, setPage] = useState(1);
    const [reportId, setReportId] = useState('');
    const [scope, setScope] = useState<'all' | 'mine'>('mine');
    const [selectedGeneration, setSelectedGeneration] = useState<AiHistoryItem | null>(null);

    const filters = useMemo<AiHistoryFilters>(() => ({
        action,
        page,
        per_page: 10,
        report_id: reportId ? Number(reportId) : undefined,
        scope: canViewAiDashboard(user) ? scope : 'mine',
    }), [action, page, reportId, scope, user]);

    const historyQuery = useAiHistoryQuery(filters);
    const meta = historyQuery.data?.meta;

    useEffect(() => {
        document.title = `AI History - ${appConfig.name}`;
    }, []);

    const resetFilters = () => {
        setAction('');
        setPage(1);
        setReportId('');
        setScope('mine');
    };

    return (
        <AiPageShell
            actions={<Button leftIcon={<RefreshCw aria-hidden="true" className="size-4" />} onClick={() => void historyQuery.refetch()} variant="outline">Refresh</Button>}
            description="Reopen previous AI generations stored through the backend activity log."
            title="AI History"
        >
            <Card>
                <CardHeader>
                    <CardTitle>Filters</CardTitle>
                    <CardDescription>Filter history without inventing unsupported API parameters.</CardDescription>
                </CardHeader>
                <CardContent className="grid gap-4 md:grid-cols-4">
                    <Select
                        label="Action"
                        onChange={(event) => {
                            setAction(event.target.value as AiAction | '');
                            setPage(1);
                        }}
                        options={[{ label: 'All actions', value: '' }, ...aiActionOptions]}
                        value={action}
                    />
                    <Input
                        label="Report ID"
                        min={1}
                        onChange={(event) => {
                            setReportId(event.target.value);
                            setPage(1);
                        }}
                        placeholder="Any report"
                        type="number"
                        value={reportId}
                    />
                    <Select
                        disabled={!canViewAiDashboard(user)}
                        label="Scope"
                        onChange={(event) => {
                            setScope(event.target.value as 'all' | 'mine');
                            setPage(1);
                        }}
                        options={aiHistoryScopeOptions}
                        value={scope}
                    />
                    <div className="flex items-end">
                        <Button className="w-full" onClick={resetFilters} variant="outline">Reset</Button>
                    </div>
                </CardContent>
            </Card>

            <div className="grid gap-6 xl:grid-cols-[minmax(0,1fr)_24rem]">
                <div className="grid gap-4">
                    {historyQuery.isLoading ? (
                        <AiSectionSkeleton />
                    ) : historyQuery.isError ? (
                        <AiErrorState error={historyQuery.error} onRetry={() => void historyQuery.refetch()} title="Unable to load AI history" />
                    ) : historyQuery.data?.data.length ? (
                        <AiHistoryList items={historyQuery.data.data} onSelect={setSelectedGeneration} />
                    ) : (
                        <AiEmptyState title="No AI history" description="No previous AI generations match the selected filters." />
                    )}

                    {meta && meta.last_page > 1 && (
                        <div className="flex flex-col gap-3 rounded-2xl border bg-surface p-4 sm:flex-row sm:items-center sm:justify-between">
                            <p className="text-sm text-muted-foreground">
                                Page {meta.current_page} of {meta.last_page} · {meta.total} generations
                            </p>
                            <div className="flex gap-2">
                                <Button disabled={page <= 1} onClick={() => setPage((current) => Math.max(1, current - 1))} variant="outline">Previous</Button>
                                <Button disabled={page >= meta.last_page} onClick={() => setPage((current) => current + 1)} variant="outline">Next</Button>
                            </div>
                        </div>
                    )}
                </div>

                <aside className="grid content-start gap-6">
                    <AiResultCard generation={selectedGeneration} title="Reopened generation" />
                    {!selectedGeneration && (
                        <EmptyState
                            icon={<History aria-hidden="true" className="size-10" />}
                            title="Select a generation"
                            description="Use Reopen to display the full historical AI result."
                        />
                    )}
                </aside>
            </div>
        </AiPageShell>
    );
}
