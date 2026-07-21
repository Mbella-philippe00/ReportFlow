import { Clock3, GitPullRequest } from 'lucide-react';
import { useEffect } from 'react';

import { Badge, Card, CardContent, CardDescription, CardHeader, CardTitle, Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui';
import { appConfig } from '@/config/app';
import { useAuthStore } from '@/stores/auth.store';

import { AnalyticsAccessDenied, AnalyticsEmptyState, AnalyticsErrorState, AnalyticsPageShell, AnalyticsSectionSkeleton, ChartCard, DonutChart, ProgressMetric, StatusDistributionList } from '../components';
import { useAnalyticsExportOptionsQuery, useAnalyticsWorkflowQuery } from '../hooks/useAnalytics';
import { useAnalyticsFilters } from '../hooks/useAnalyticsFilters';
import { canViewAnalytics, formatAnalyticsNumber, getStatusChartColor, getWorkflowStageLabel } from '../utils/analytics-utils';

export function WorkflowAnalyticsPage() {
    const user = useAuthStore((state) => state.user);
    const { filters, queryFilters, resetFilters, setFilters } = useAnalyticsFilters();
    const workflowQuery = useAnalyticsWorkflowQuery(queryFilters);
    const exportOptionsQuery = useAnalyticsExportOptionsQuery();

    useEffect(() => {
        document.title = `Workflow Analytics - ${appConfig.name}`;
    }, []);

    if (!canViewAnalytics(user)) {
        return <AnalyticsAccessDenied />;
    }

    const workflow = workflowQuery.data?.data.data;

    return (
        <AnalyticsPageShell
            description="Analyze workflow distribution, approval bottlenecks, average processing time, and transition rates."
            exportOptions={exportOptionsQuery.data?.data}
            exportOptionsLoading={exportOptionsQuery.isLoading}
            filters={filters}
            onFiltersChange={setFilters}
            onFiltersReset={resetFilters}
            title="Workflow Analytics"
        >
            {workflowQuery.isLoading ? (
                <>
                    <AnalyticsSectionSkeleton />
                    <AnalyticsSectionSkeleton />
                </>
            ) : workflowQuery.isError ? (
                <AnalyticsErrorState error={workflowQuery.error} onRetry={() => void workflowQuery.refetch()} title="Unable to load workflow analytics" />
            ) : workflow ? (
                <>
                    <div className="grid gap-6 xl:grid-cols-[1fr_0.9fr]">
                        <ChartCard
                            badge={<Badge intent="primary">{formatAnalyticsNumber(workflowQuery.data?.data.meta.total_reports ?? 0)} reports</Badge>}
                            description="Current report distribution across workflow states."
                            title="Current workflow distribution"
                        >
                            <DonutChart
                                ariaLabel="Workflow distribution donut chart"
                                data={workflow.current_distribution.map((status) => ({ color: getStatusChartColor(status.value), label: status.label, value: status.count }))}
                            />
                        </ChartCard>

                        <Card>
                            <CardHeader>
                                <div className="flex items-start justify-between gap-3">
                                    <div>
                                        <CardTitle>Transition rates</CardTitle>
                                        <CardDescription>How reports move through the backend workflow.</CardDescription>
                                    </div>
                                    <GitPullRequest aria-hidden="true" className="size-5 text-primary" />
                                </div>
                            </CardHeader>
                            <CardContent className="grid gap-4">
                                <ProgressMetric label="Submission rate" value={workflow.transition_rates.submission_rate} />
                                <ProgressMetric label="Manager approval rate" value={workflow.transition_rates.manager_approval_rate} />
                                <ProgressMetric label="Final approval rate" value={workflow.transition_rates.final_approval_rate} />
                                <ProgressMetric label="Rejection rate" value={workflow.transition_rates.rejection_rate} />
                            </CardContent>
                        </Card>
                    </div>

                    <div className="grid gap-6 xl:grid-cols-2">
                        <Card>
                            <CardHeader>
                                <div className="flex items-start justify-between gap-3">
                                    <div>
                                        <CardTitle>Average processing time</CardTitle>
                                        <CardDescription>Average time from submission to decision.</CardDescription>
                                    </div>
                                    <Clock3 aria-hidden="true" className="size-5 text-primary" />
                                </div>
                            </CardHeader>
                            <CardContent>
                                <div className="rounded-2xl border bg-muted/30 p-5">
                                    <p className="text-sm text-muted-foreground">Average processing time</p>
                                    <p className="mt-2 text-4xl font-semibold text-foreground">{workflow.average_processing_time.human}</p>
                                    <p className="mt-2 text-sm text-muted-foreground">
                                        {formatAnalyticsNumber(workflow.average_processing_time.minutes)} minutes ? {formatAnalyticsNumber(workflow.average_processing_time.hours)} hours
                                    </p>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Status detail</CardTitle>
                                <CardDescription>Counts for every workflow status.</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <StatusDistributionList statuses={workflow.current_distribution} />
                            </CardContent>
                        </Card>
                    </div>

                    <Card>
                        <CardHeader>
                            <CardTitle>Approval bottlenecks</CardTitle>
                            <CardDescription>Pending reports and average wait time for workflow stages.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            {workflow.approval_bottlenecks.length === 0 ? (
                                <AnalyticsEmptyState title="No workflow bottlenecks" />
                            ) : (
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead>Stage</TableHead>
                                            <TableHead>Status</TableHead>
                                            <TableHead className="text-right">Pending reports</TableHead>
                                            <TableHead className="text-right">Average wait</TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        {workflow.approval_bottlenecks.map((bottleneck) => (
                                            <TableRow key={bottleneck.stage}>
                                                <TableCell className="font-medium">{getWorkflowStageLabel(bottleneck.stage)}</TableCell>
                                                <TableCell><Badge intent="neutral">{bottleneck.status.replaceAll('_', ' ')}</Badge></TableCell>
                                                <TableCell className="text-right">{formatAnalyticsNumber(bottleneck.pending_reports)}</TableCell>
                                                <TableCell className="text-right">{bottleneck.average_wait_time.human}</TableCell>
                                            </TableRow>
                                        ))}
                                    </TableBody>
                                </Table>
                            )}
                        </CardContent>
                    </Card>
                </>
            ) : (
                <AnalyticsEmptyState />
            )}
        </AnalyticsPageShell>
    );
}
