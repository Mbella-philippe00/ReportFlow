import { AlertTriangle, Award, BriefcaseBusiness, FileSpreadsheet, LineChart as LineChartIcon, Target } from 'lucide-react';
import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

import { NoPermission } from '@/components/business';
import { PageContainer } from '@/components/layout/PageContainer';
import { Badge, Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';
import { appConfig } from '@/config/app';
import { useAuthStore } from '@/stores/auth.store';

import { AnalyticsCardsSkeleton, AnalyticsEmptyState, AnalyticsErrorState, AnalyticsPageShell, AnalyticsSectionSkeleton, BarChart, ChartCard, LineChart, ProgressMetric } from '../components';
import { useAnalyticsExportOptionsQuery, useExecutiveAnalyticsDashboardQuery, useExecutiveKpiCenterQuery, useExecutiveReportQuery } from '../hooks/useAnalytics';
import { useAnalyticsFilters } from '../hooks/useAnalyticsFilters';
import { canViewAnalytics, formatAnalyticsNumber, formatAnalyticsPercent, getChartPaletteColor } from '../utils/analytics-utils';

const severityIntent = (severity: string) => {
    if (severity === 'critical') {
        return 'danger' as const;
    }

    if (severity === 'high') {
        return 'warning' as const;
    }

    return 'primary' as const;
};

export function ExecutiveAnalyticsPage() {
    const navigate = useNavigate();
    const user = useAuthStore((state) => state.user);
    const { filters, queryFilters, resetFilters, setFilters } = useAnalyticsFilters();
    const dashboardQuery = useExecutiveAnalyticsDashboardQuery(queryFilters);
    const kpiQuery = useExecutiveKpiCenterQuery(queryFilters);
    const reportQuery = useExecutiveReportQuery(queryFilters);
    const exportOptionsQuery = useAnalyticsExportOptionsQuery();

    useEffect(() => {
        document.title = 'Executive Analytics - ' + appConfig.name;
    }, []);

    if (!canViewAnalytics(user)) {
        return (
            <PageContainer description='Executive analytics are restricted by the backend Analytics policy.' eyebrow='Analytics' title='Executive Analytics'>
                <NoPermission
                    action={{ label: 'Go to dashboard', onClick: () => navigate('/dashboard') }}
                    description='Managers and super-admins can access the executive decision-support center.'
                    title='Executive analytics access restricted'
                />
            </PageContainer>
        );
    }

    const dashboard = dashboardQuery.data?.data.data;
    const metrics = dashboard?.headline_metrics;
    const kpis = kpiQuery.data?.data.data.kpis ?? [];
    const executiveReport = reportQuery.data?.data.data;

    return (
        <AnalyticsPageShell
            description='Executive decision-support across KPIs, departments, employees, workflow risk, documents, and smart alerts.'
            exportOptions={exportOptionsQuery.data?.data}
            exportOptionsLoading={exportOptionsQuery.isLoading}
            filters={filters}
            onFiltersChange={setFilters}
            onFiltersReset={resetFilters}
            showGranularity
            title='Executive Analytics & KPI Center'
        >
            {dashboardQuery.isLoading ? (
                <AnalyticsCardsSkeleton count={8} />
            ) : dashboardQuery.isError ? (
                <AnalyticsErrorState error={dashboardQuery.error} onRetry={() => void dashboardQuery.refetch()} title='Unable to load executive dashboard' />
            ) : metrics ? (
                <div className='grid gap-4 md:grid-cols-2 xl:grid-cols-4'>
                    <Card><CardHeader><CardDescription>Total reports</CardDescription><CardTitle>{formatAnalyticsNumber(metrics.total_reports)}</CardTitle></CardHeader></Card>
                    <Card><CardHeader><CardDescription>Completion rate</CardDescription><CardTitle>{formatAnalyticsPercent(metrics.completion_rate)}</CardTitle></CardHeader></Card>
                    <Card><CardHeader><CardDescription>Approval rate</CardDescription><CardTitle>{formatAnalyticsPercent(metrics.approval_rate)}</CardTitle></CardHeader></Card>
                    <Card><CardHeader><CardDescription>Smart alerts</CardDescription><CardTitle>{formatAnalyticsNumber(metrics.smart_alerts_count)}</CardTitle></CardHeader></Card>
                    <Card><CardHeader><CardDescription>Pending workflow</CardDescription><CardTitle>{formatAnalyticsNumber(metrics.pending_reports)}</CardTitle></CardHeader></Card>
                    <Card><CardHeader><CardDescription>Rejected reports</CardDescription><CardTitle>{formatAnalyticsNumber(metrics.rejected_reports)}</CardTitle></CardHeader></Card>
                    <Card><CardHeader><CardDescription>Documents attached</CardDescription><CardTitle>{formatAnalyticsNumber(metrics.documents_count)}</CardTitle></CardHeader></Card>
                    <Card><CardHeader><CardDescription>Avg approval cycle</CardDescription><CardTitle>{metrics.average_approval_time.human}</CardTitle></CardHeader></Card>
                </div>
            ) : null}

            {kpiQuery.isLoading ? (
                <AnalyticsSectionSkeleton />
            ) : kpiQuery.isError ? (
                <AnalyticsErrorState error={kpiQuery.error} onRetry={() => void kpiQuery.refetch()} title='Unable to load KPI center' />
            ) : (
                <div className='grid gap-4 md:grid-cols-2 xl:grid-cols-3'>
                    {kpis.map((kpi) => (
                        <Card key={kpi.id}>
                            <CardHeader className='flex-row items-start justify-between gap-3'>
                                <div>
                                    <CardDescription>{kpi.unit}</CardDescription>
                                    <CardTitle>{kpi.label}</CardTitle>
                                </div>
                                <Badge intent={kpi.status === 'on_track' ? 'success' : 'warning'}>{kpi.status === 'on_track' ? 'On track' : 'Attention'}</Badge>
                            </CardHeader>
                            <CardContent className='grid gap-3'>
                                <div className='flex items-end justify-between gap-3'>
                                    <p className='text-3xl font-semibold text-foreground'>{formatAnalyticsNumber(kpi.value)}</p>
                                    <p className='text-sm text-muted-foreground'>Target {formatAnalyticsNumber(kpi.target)}</p>
                                </div>
                                <ProgressMetric label='Target progress' value={kpi.unit === '%' ? kpi.value : Math.min(100, (kpi.value / Math.max(kpi.target, 1)) * 100)} />
                            </CardContent>
                        </Card>
                    ))}
                </div>
            )}

            {dashboard ? (
                <div className='grid gap-6 xl:grid-cols-[1.3fr_1fr]'>
                    <ChartCard badge={<Badge intent='primary'>Interactive</Badge>} description='Executive trendline for report volume over the selected period.' title='Executive report trend'>
                        {dashboard.trendlines.length > 0 ? (
                            <LineChart ariaLabel='Executive report trend chart' data={dashboard.trendlines.map((point) => ({ label: point.label, value: point.total_reports }))} />
                        ) : (
                            <AnalyticsEmptyState title='No trend data' />
                        )}
                    </ChartCard>

                    <ChartCard badge={<LineChartIcon aria-hidden='true' className='size-5 text-primary' />} description='Top departments ranked by balanced executive score.' title='Department comparison'>
                        <BarChart ariaLabel='Department comparison chart' data={dashboard.department_leaders.map((department, index) => ({ color: getChartPaletteColor(index), label: department.department, value: department.score }))} />
                    </ChartCard>
                </div>
            ) : null}

            {dashboard ? (
                <div className='grid gap-6 xl:grid-cols-2'>
                    <Card>
                        <CardHeader className='flex-row items-start justify-between gap-3'>
                            <div>
                                <CardTitle>Employee comparison</CardTitle>
                                <CardDescription>Top contributors by submission and approval score.</CardDescription>
                            </div>
                            <Award aria-hidden='true' className='size-5 text-primary' />
                        </CardHeader>
                        <CardContent className='grid gap-3'>
                            {dashboard.employee_leaders.map((employee) => (
                                <div className='flex items-center justify-between gap-3 rounded-xl border bg-muted/30 p-3' key={employee.employee.id}>
                                    <div>
                                        <p className='font-medium text-foreground'>{employee.rank}. {employee.employee.name}</p>
                                        <p className='text-xs text-muted-foreground'>{employee.employee.department}</p>
                                    </div>
                                    <Badge intent='primary'>{formatAnalyticsNumber(employee.score)}</Badge>
                                </div>
                            ))}
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className='flex-row items-start justify-between gap-3'>
                            <div>
                                <CardTitle>Smart alerts</CardTitle>
                                <CardDescription>Decision-support warnings generated from workflow and quality signals.</CardDescription>
                            </div>
                            <AlertTriangle aria-hidden='true' className='size-5 text-warning' />
                        </CardHeader>
                        <CardContent className='grid gap-3'>
                            {dashboard.smart_alerts.length === 0 ? (
                                <AnalyticsEmptyState description='No executive alerts for the selected filters.' title='No smart alerts' />
                            ) : dashboard.smart_alerts.map((alert) => (
                                <div className='rounded-xl border bg-muted/30 p-3' key={alert.id}>
                                    <div className='flex items-center justify-between gap-3'>
                                        <p className='font-medium text-foreground'>{alert.title}</p>
                                        <Badge intent={severityIntent(alert.severity)}>{alert.severity}</Badge>
                                    </div>
                                    <p className='mt-2 text-sm text-muted-foreground'>{alert.message}</p>
                                </div>
                            ))}
                        </CardContent>
                    </Card>
                </div>
            ) : null}

            <div className='grid gap-6 xl:grid-cols-[1fr_1fr]'>
                <Card>
                    <CardHeader className='flex-row items-start justify-between gap-3'>
                        <div>
                            <CardTitle>Executive decision brief</CardTitle>
                            <CardDescription>Generated analytics narrative for leadership review.</CardDescription>
                        </div>
                        <BriefcaseBusiness aria-hidden='true' className='size-5 text-primary' />
                    </CardHeader>
                    <CardContent className='grid gap-3'>
                        {reportQuery.isLoading ? <AnalyticsSectionSkeleton /> : executiveReport ? (
                            <>
                                {executiveReport.summary.map((item) => <p className='rounded-xl bg-muted/40 p-3 text-sm text-foreground' key={item}>{item}</p>)}
                                <div>
                                    <p className='text-sm font-semibold text-foreground'>Recommendations</p>
                                    <ul className='mt-2 grid gap-2 text-sm text-muted-foreground'>
                                        {executiveReport.recommendations.map((item) => <li className='rounded-xl border p-3' key={item}>{item}</li>)}
                                    </ul>
                                </div>
                            </>
                        ) : <AnalyticsEmptyState title='No executive brief' />}
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader className='flex-row items-start justify-between gap-3'>
                        <div>
                            <CardTitle>Export center</CardTitle>
                            <CardDescription>Use the page export button to download CSV, Excel, or PDF executive analytics.</CardDescription>
                        </div>
                        <FileSpreadsheet aria-hidden='true' className='size-5 text-primary' />
                    </CardHeader>
                    <CardContent className='grid gap-3 text-sm text-muted-foreground'>
                        <p>Available datasets: executive, KPIs, comparisons, and alerts.</p>
                        <p>Exports respect the active period, department, employee, status, and trend filters.</p>
                        <p className='flex items-center gap-2 text-foreground'><Target aria-hidden='true' className='size-4 text-primary' /> Built for board-ready operational review.</p>
                    </CardContent>
                </Card>
            </div>
        </AnalyticsPageShell>
    );
}
