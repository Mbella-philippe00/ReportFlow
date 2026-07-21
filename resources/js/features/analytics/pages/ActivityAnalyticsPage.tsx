import { Activity, CheckCircle2, Send, XCircle } from 'lucide-react';
import { useEffect, useMemo } from 'react';

import { StatCard } from '@/components/business';
import { Card, CardContent, CardDescription, CardHeader, CardTitle, Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui';
import { appConfig } from '@/config/app';
import { useAuthStore } from '@/stores/auth.store';

import { ActivityTimeline, AnalyticsAccessDenied, AnalyticsCardsSkeleton, AnalyticsEmptyState, AnalyticsErrorState, AnalyticsPageShell } from '../components';
import { useAnalyticsActivityQuery, useAnalyticsExportOptionsQuery } from '../hooks/useAnalytics';
import { useAnalyticsFilters } from '../hooks/useAnalyticsFilters';
import { canViewAnalytics, formatAnalyticsDateTime, formatAnalyticsNumber, formatRelativeTime } from '../utils/analytics-utils';

export function ActivityAnalyticsPage() {
    const user = useAuthStore((state) => state.user);
    const { filters, queryFilters, resetFilters, setFilters } = useAnalyticsFilters();
    const activityQuery = useAnalyticsActivityQuery(queryFilters);
    const exportOptionsQuery = useAnalyticsExportOptionsQuery();

    useEffect(() => {
        document.title = `Activity Analytics - ${appConfig.name}`;
    }, []);

    if (!canViewAnalytics(user)) {
        return <AnalyticsAccessDenied />;
    }

    const activities = activityQuery.data?.data ?? [];
    const activityCounts = useMemo(
        () => ({
            approval: activities.filter((item) => item.type === 'approval').length,
            rejection: activities.filter((item) => item.type === 'rejection').length,
            submission: activities.filter((item) => item.type === 'submission').length,
            total: activities.length,
        }),
        [activities],
    );

    return (
        <AnalyticsPageShell
            description="Review recent workflow activity returned by the Analytics activity endpoint."
            exportOptions={exportOptionsQuery.data?.data}
            exportOptionsLoading={exportOptionsQuery.isLoading}
            filters={filters}
            onFiltersChange={setFilters}
            onFiltersReset={resetFilters}
            title="Activity Analytics"
        >
            {activityQuery.isLoading ? (
                <AnalyticsCardsSkeleton count={4} />
            ) : activityQuery.isError ? (
                <AnalyticsErrorState error={activityQuery.error} onRetry={() => void activityQuery.refetch()} title="Unable to load activity analytics" />
            ) : activities.length === 0 ? (
                <AnalyticsEmptyState description="Workflow activity will appear when matching activity logs exist." title="No analytical activity" />
            ) : (
                <>
                    <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <StatCard description="Recent workflow events returned by the backend." icon={<Activity aria-hidden="true" className="size-5" />} title="Total activity" value={formatAnalyticsNumber(activityCounts.total)} />
                        <StatCard description="Report submission activity." icon={<Send aria-hidden="true" className="size-5" />} title="Submissions" value={formatAnalyticsNumber(activityCounts.submission)} />
                        <StatCard description="Approval or validation activity." icon={<CheckCircle2 aria-hidden="true" className="size-5" />} title="Approvals" value={formatAnalyticsNumber(activityCounts.approval)} />
                        <StatCard description="Rejected workflow activity." icon={<XCircle aria-hidden="true" className="size-5" />} title="Rejections" value={formatAnalyticsNumber(activityCounts.rejection)} />
                    </div>

                    <ActivityTimeline activities={activities} />

                    <Card>
                        <CardHeader>
                            <CardTitle>Activity detail</CardTitle>
                            <CardDescription>Raw analytical activity rows from `/api/analytics/activity`.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Activity</TableHead>
                                        <TableHead>Actor</TableHead>
                                        <TableHead>Report</TableHead>
                                        <TableHead>Type</TableHead>
                                        <TableHead className="text-right">Occurred</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {activities.map((activity) => (
                                        <TableRow key={activity.id}>
                                            <TableCell className="font-medium">{activity.description}</TableCell>
                                            <TableCell>{activity.causer?.name ?? activity.causer?.email ?? 'System'}</TableCell>
                                            <TableCell>{activity.report_id ? `#${activity.report_id}` : 'N/A'}</TableCell>
                                            <TableCell>{activity.type}</TableCell>
                                            <TableCell className="text-right">
                                                <span className="block font-medium">{formatRelativeTime(activity.occurred_at)}</span>
                                                <span className="text-xs text-muted-foreground">{formatAnalyticsDateTime(activity.occurred_at)}</span>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>
                </>
            )}
        </AnalyticsPageShell>
    );
}
