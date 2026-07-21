import { Activity, BarChart3, GitPullRequest, Inbox, LineChart as LineChartIcon } from 'lucide-react';
import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

import { NoPermission } from '@/components/business';
import { PageContainer } from '@/components/layout/PageContainer';
import { Badge, Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';
import { appConfig } from '@/config/app';
import { useAuthStore } from '@/stores/auth.store';

import { AnalyticsKpiGrid, ActivityTimeline, AnalyticsCardsSkeleton, AnalyticsEmptyState, AnalyticsErrorState, AnalyticsPageShell, AnalyticsSectionSkeleton, AreaChart, ChartCard, DonutChart, LineChart, ProgressMetric } from '../components';
import { useAnalyticsActivityQuery, useAnalyticsExportOptionsQuery, useAnalyticsOverviewQuery, useAnalyticsReportsQuery, useAnalyticsTrendsQuery, useAnalyticsWorkflowQuery } from '../hooks/useAnalytics';
import { useAnalyticsFilters } from '../hooks/useAnalyticsFilters';
import { canViewAnalytics, formatAnalyticsNumber, getStatusChartColor } from '../utils/analytics-utils';

export function AnalyticsDashboardPage() {
    const navigate = useNavigate();
    const user = useAuthStore((state) => state.user);
    const { filters, queryFilters, resetFilters, setFilters } = useAnalyticsFilters();
    const overviewQuery = useAnalyticsOverviewQuery(queryFilters);
    const trendsQuery = useAnalyticsTrendsQuery(queryFilters);
    const reportsQuery = useAnalyticsReportsQuery(queryFilters);
    const workflowQuery = useAnalyticsWorkflowQuery(queryFilters);
    const activityQuery = useAnalyticsActivityQuery(queryFilters);
    const exportOptionsQuery = useAnalyticsExportOptionsQuery();

    useEffect(() => {
        document.title = `Analytics - ${appConfig.name}`;
    }, []);

    if (!canViewAnalytics(user)) {
        return (
            <PageContainer description="Analytics are restricted by the backend Analytics policy." eyebrow="Analytics" title="Analytics">
                <NoPermission
                    action={{ label: 'Go to dashboard', onClick: () => navigate('/dashboard') }}
                    description="Your current role cannot access the Analytics REST API. Managers and super-admins can view analytics."
                    title="Analytics access restricted"
                />
            </PageContainer>
        );
    }

    const trendPoints = trendsQuery.data?.data.data ?? [];
    const reportsData = reportsQuery.data?.data.data;
    const workflowData = workflowQuery.data?.data.data;
    const activities = activityQuery.data?.data ?? [];

    return (
        <AnalyticsPageShell
            description="Executive analytics across reports, workflow, employees, departments, PowerPoint generation, and activity."
            exportOptions={exportOptionsQuery.data?.data}
            exportOptionsLoading={exportOptionsQuery.isLoading}
            filters={filters}
            onFiltersChange={setFilters}
            onFiltersReset={resetFilters}
            showGranularity
            title="Analytics Dashboard"
        >
            {overviewQuery.isLoading ? (
                <AnalyticsCardsSkeleton count={8} />
            ) : overviewQuery.isError ? (
                <AnalyticsErrorState error={overviewQuery.error} onRetry={() => void overviewQuery.refetch()} title="Unable to load analytics overview" />
            ) : overviewQuery.data ? (
                <AnalyticsKpiGrid overview={overviewQuery.data.data} />
            ) : null}

            <div className="grid gap-6 xl:grid-cols-[1.5fr_1fr]">
                {trendsQuery.isLoading ? (
                    <AnalyticsSectionSkeleton />
                ) : trendsQuery.isError ? (
                    <AnalyticsErrorState error={trendsQuery.error} onRetry={() => void trendsQuery.refetch()} title="Unable to load trends" />
                ) : trendPoints.length === 0 ? (
                    <AnalyticsEmptyState description="Weekly, monthly, or yearly trends will appear when reports match the filters." title="No trend data" />
                ) : (
                    <ChartCard
                        badge={<Badge intent="primary">{trendsQuery.data?.data.meta.granularity ?? 'weekly'}</Badge>}
                        description="Report volume over the selected period."
                        title="Report trends"
                    >
                        <LineChart ariaLabel="Report trends line chart" data={trendPoints.map((point) => ({ label: point.label, value: point.total_reports }))} />
                    </ChartCard>
                )}

                {reportsQuery.isLoading ? (
                    <AnalyticsSectionSkeleton />
                ) : reportsQuery.isError ? (
                    <AnalyticsErrorState error={reportsQuery.error} onRetry={() => void reportsQuery.refetch()} title="Unable to load report distribution" />
                ) : reportsData ? (
                    <ChartCard
                        badge={<Badge intent="neutral">{formatAnalyticsNumber(reportsQuery.data?.data.meta.total_reports ?? 0)} total</Badge>}
                        description="Current report status distribution."
                        title="Status distribution"
                    >
                        <DonutChart
                            ariaLabel="Report status distribution donut chart"
                            data={reportsData.status_distribution.map((status) => ({ color: getStatusChartColor(status.value), label: status.label, value: status.count }))}
                        />
                    </ChartCard>
                ) : null}
            </div>

            <div className="grid gap-6 xl:grid-cols-2">
                {trendsQuery.isLoading ? (
                    <AnalyticsSectionSkeleton />
                ) : trendPoints.length > 0 ? (
                    <ChartCard description="Approved report trend for the selected period." title="Approved reports trend">
                        <AreaChart ariaLabel="Approved reports area chart" data={trendPoints.map((point) => ({ label: point.label, value: point.generated_reports }))} />
                    </ChartCard>
                ) : (
                    <AnalyticsEmptyState title="No approved trend" />
                )}

                {workflowQuery.isLoading ? (
                    <AnalyticsSectionSkeleton />
                ) : workflowQuery.isError ? (
                    <AnalyticsErrorState error={workflowQuery.error} onRetry={() => void workflowQuery.refetch()} title="Unable to load workflow analytics" />
                ) : workflowData ? (
                    <Card>
                        <CardHeader>
                            <CardTitle>Workflow health</CardTitle>
                            <CardDescription>Transition rates and current approval flow.</CardDescription>
                        </CardHeader>
                        <CardContent className="grid gap-4">
                            <ProgressMetric label="Submission rate" value={workflowData.transition_rates.submission_rate} />
                            <ProgressMetric label="Manager approval rate" value={workflowData.transition_rates.manager_approval_rate} />
                            <ProgressMetric label="Final approval rate" value={workflowData.transition_rates.final_approval_rate} />
                            <ProgressMetric label="Rejection rate" value={workflowData.transition_rates.rejection_rate} />
                        </CardContent>
                    </Card>
                ) : null}
            </div>

            {activityQuery.isLoading ? (
                <AnalyticsSectionSkeleton />
            ) : activityQuery.isError ? (
                <AnalyticsErrorState error={activityQuery.error} onRetry={() => void activityQuery.refetch()} title="Unable to load activity" />
            ) : activities.length > 0 ? (
                <ActivityTimeline activities={activities} />
            ) : (
                <AnalyticsEmptyState description="Recent workflow activity will appear when matching activity logs exist." title="No recent activity" />
            )}

            <div className="grid gap-4 md:grid-cols-3">
                <Card>
                    <CardHeader className="flex-row items-start justify-between gap-3">
                        <div>
                            <CardDescription>Reports analytics</CardDescription>
                            <CardTitle>Status and generation</CardTitle>
                        </div>
                        <BarChart3 aria-hidden="true" className="size-5 text-primary" />
                    </CardHeader>
                </Card>
                <Card>
                    <CardHeader className="flex-row items-start justify-between gap-3">
                        <div>
                            <CardDescription>Workflow analytics</CardDescription>
                            <CardTitle>Bottlenecks and rates</CardTitle>
                        </div>
                        <GitPullRequest aria-hidden="true" className="size-5 text-primary" />
                    </CardHeader>
                </Card>
                <Card>
                    <CardHeader className="flex-row items-start justify-between gap-3">
                        <div>
                            <CardDescription>Activity analytics</CardDescription>
                            <CardTitle>Latest audit signals</CardTitle>
                        </div>
                        {activities.length > 0 ? <Activity aria-hidden="true" className="size-5 text-primary" /> : <Inbox aria-hidden="true" className="size-5 text-muted-foreground" />}
                    </CardHeader>
                </Card>
            </div>
        </AnalyticsPageShell>
    );
}
