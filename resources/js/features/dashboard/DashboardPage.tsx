import { useQuery } from '@tanstack/react-query';
import {
    AlertCircle,
    ArrowRight,
    BarChart3,
    CheckCircle2,
    Clock3,
    FilePlus2,
    FileText,
    GitPullRequest,
    Inbox,
    RefreshCw,
    Sparkles,
    TrendingUp,
    XCircle,
} from 'lucide-react';
import { useEffect, useMemo } from 'react';
import { useNavigate } from 'react-router-dom';

import {
    ApprovalTimeline,
    KPIWidget,
    MetricCard,
    NotificationList,
    ReportCard,
    ReportStatusBadge,
    SectionHeader,
    StatCard,
} from '@/components/business';
import type { ApprovalTimelineItem, NotificationListEntry } from '@/components/business';
import { PageContainer } from '@/components/layout/PageContainer';
import {
    Alert,
    Badge,
    Button,
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
    EmptyState,
    Skeleton,
} from '@/components/ui';
import { appConfig } from '@/config/app';
import { dashboardQueryKeys, getDashboard } from '@/services/dashboard.service';
import { listReports, reportsQueryKeys } from '@/services/reports.service';
import type { DashboardCharts, DashboardData, DashboardStatistics, ReportStatusValue, WeeklyReport } from '@/types';

const reportStatusValues = ['draft', 'submitted', 'manager_approved', 'generated', 'rejected'] as const;
const reportStatusOrder: readonly string[] = reportStatusValues;

const reportStatusLabels: Record<string, string> = {
    draft: 'Draft',
    generated: 'Generated',
    manager_approved: 'Manager approved',
    rejected: 'Rejected',
    submitted: 'Submitted',
};

const statusBarClasses: Record<string, string> = {
    draft: 'bg-muted-foreground',
    generated: 'bg-primary',
    manager_approved: 'bg-success',
    rejected: 'bg-danger',
    submitted: 'bg-warning',
};

const statusMetricIntent: Record<string, 'danger' | 'neutral' | 'primary' | 'success' | 'warning'> = {
    draft: 'neutral',
    generated: 'primary',
    manager_approved: 'success',
    rejected: 'danger',
    submitted: 'warning',
};

const numberFormatter = new Intl.NumberFormat('en-US');
const dateFormatter = new Intl.DateTimeFormat('en-US', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
});

const isReportStatusValue = (status: string): status is ReportStatusValue =>
    reportStatusValues.includes(status as ReportStatusValue);

const formatNumber = (value: number) => numberFormatter.format(value);

const formatPercent = (value: number) => `${numberFormatter.format(value)}%`;

const formatDate = (value: string | null | undefined) => {
    if (!value) {
        return 'Not available';
    }

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return 'Not available';
    }

    return dateFormatter.format(date);
};

const formatRelativeTime = (value: string | null | undefined) => {
    if (!value) {
        return 'Not available';
    }

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return 'Not available';
    }

    const elapsedMilliseconds = Date.now() - date.getTime();
    const elapsedMinutes = Math.max(0, Math.floor(elapsedMilliseconds / 60_000));

    if (elapsedMinutes < 1) {
        return 'Just now';
    }

    if (elapsedMinutes < 60) {
        return `${elapsedMinutes}m ago`;
    }

    const elapsedHours = Math.floor(elapsedMinutes / 60);

    if (elapsedHours < 24) {
        return `${elapsedHours}h ago`;
    }

    const elapsedDays = Math.floor(elapsedHours / 24);

    if (elapsedDays < 7) {
        return `${elapsedDays}d ago`;
    }

    return formatDate(value);
};

const truncateText = (value: string | null | undefined, maxLength = 160) => {
    if (!value) {
        return undefined;
    }

    if (value.length <= maxLength) {
        return value;
    }

    return `${value.slice(0, maxLength - 1)}…`;
};

const getEmployeeName = (report: WeeklyReport) =>
    report.employee.name ?? report.employee.email ?? 'Unassigned employee';

const getReportTitle = (report: WeeklyReport) => `${getEmployeeName(report)} · Week ${report.week}`;

const getReportDescription = (report: WeeklyReport) =>
    truncateText(report.executive_summary ?? report.achievements ?? report.activities ?? report.objectives);

const getReportProgress = (status: ReportStatusValue) => {
    const progressByStatus: Record<ReportStatusValue, number> = {
        draft: 20,
        generated: 100,
        manager_approved: 80,
        rejected: 100,
        submitted: 55,
    };

    return progressByStatus[status];
};

const getErrorMessage = (error: unknown) => {
    if (error instanceof Error) {
        return error.message;
    }

    return 'The request failed unexpectedly.';
};

const getStatusOrder = (status: string) => {
    const index = reportStatusOrder.indexOf(status);

    return index === -1 ? reportStatusOrder.length : index;
};

const getStatusLabel = (status: string) => reportStatusLabels[status] ?? status.replaceAll('_', ' ');

const getStatusBarClass = (status: string) => statusBarClasses[status] ?? 'bg-primary';

const getMetricIntent = (status: string) => statusMetricIntent[status] ?? 'neutral';

function DashboardErrorAlert({ error, onRetry, title }: { error: unknown; onRetry: () => void; title: string }) {
    return (
        <Alert
            description={
                <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <span>{getErrorMessage(error)}</span>
                    <Button leftIcon={<RefreshCw aria-hidden="true" className="size-4" />} onClick={onRetry} size="sm" variant="outline">
                        Retry
                    </Button>
                </div>
            }
            icon={<AlertCircle aria-hidden="true" className="size-5" />}
            intent="danger"
            title={title}
        />
    );
}

function CardGridSkeleton({ count }: { count: number }) {
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

function SectionCardSkeleton() {
    return (
        <Card>
            <CardHeader>
                <Skeleton className="h-5 w-40" />
                <Skeleton className="h-4 w-64 max-w-full" />
            </CardHeader>
            <CardContent className="grid gap-3">
                <Skeleton className="h-14 w-full" />
                <Skeleton className="h-14 w-full" />
                <Skeleton className="h-14 w-full" />
            </CardContent>
        </Card>
    );
}

function KpiSection({ loading, statistics }: { loading: boolean; statistics?: DashboardStatistics }) {
    if (loading) {
        return <CardGridSkeleton count={5} />;
    }

    if (!statistics) {
        return (
            <EmptyState
                description="Dashboard statistics are not available from the API response."
                icon={<Inbox aria-hidden="true" className="size-10" />}
                title="No KPI data"
            />
        );
    }

    return (
        <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <StatCard
                description="All weekly reports in the system."
                icon={<FileText aria-hidden="true" className="size-5" />}
                title="Total reports"
                value={formatNumber(statistics.total_reports)}
            />
            <StatCard
                description="Submitted reports waiting for approval."
                icon={<Clock3 aria-hidden="true" className="size-5" />}
                title="Pending approvals"
                value={formatNumber(statistics.pending_reports)}
            />
            <StatCard
                description="Reports with generated PowerPoint output."
                icon={<CheckCircle2 aria-hidden="true" className="size-5" />}
                title="Generated reports"
                value={formatNumber(statistics.generated_reports)}
            />
            <StatCard
                description="Reports rejected during workflow review."
                icon={<XCircle aria-hidden="true" className="size-5" />}
                title="Rejected reports"
                value={formatNumber(statistics.rejected_reports)}
            />
            <StatCard
                description="Generated reports compared with total reports."
                icon={<TrendingUp aria-hidden="true" className="size-5" />}
                title="Validation rate"
                value={formatPercent(statistics.validation_rate)}
            />
        </div>
    );
}

function OperationalMetrics({ charts, loading, statistics }: { charts?: DashboardCharts; loading: boolean; statistics?: DashboardStatistics }) {
    if (loading) {
        return <SectionCardSkeleton />;
    }

    if (!statistics || !charts) {
        return (
            <EmptyState
                description="Operational metrics will appear when the Dashboard API returns statistics and chart data."
                icon={<BarChart3 aria-hidden="true" className="size-10" />}
                title="No operational metrics"
            />
        );
    }

    const statusEntries = Object.entries(charts.reports_by_status).sort(
        ([leftStatus], [rightStatus]) => getStatusOrder(leftStatus) - getStatusOrder(rightStatus),
    );

    return (
        <Card>
            <CardHeader>
                <CardTitle>Operational metrics</CardTitle>
                <CardDescription>Current workflow health from the Dashboard API.</CardDescription>
            </CardHeader>
            <CardContent className="grid gap-4">
                <KPIWidget
                    description="Ratio of generated reports to all weekly reports."
                    progress={statistics.validation_rate}
                    title="Validation rate"
                    value={formatPercent(statistics.validation_rate)}
                />
                <div className="grid gap-3 sm:grid-cols-2">
                    {statusEntries.map(([status, count]) => (
                        <MetricCard
                            helperText={`${formatNumber(count)} ${count === 1 ? 'report' : 'reports'}`}
                            intent={getMetricIntent(status)}
                            key={status}
                            label={getStatusLabel(status)}
                            value={formatNumber(count)}
                        />
                    ))}
                </div>
            </CardContent>
        </Card>
    );
}

function ReportsByStatusChart({ charts, loading }: { charts?: DashboardCharts; loading: boolean }) {
    if (loading) {
        return <SectionCardSkeleton />;
    }

    const statusEntries = charts
        ? Object.entries(charts.reports_by_status).sort(([leftStatus], [rightStatus]) => getStatusOrder(leftStatus) - getStatusOrder(rightStatus))
        : [];
    const total = statusEntries.reduce((sum, [, count]) => sum + count, 0);

    if (statusEntries.length === 0 || total === 0) {
        return (
            <EmptyState
                description="Report status distribution will appear when weekly reports exist."
                icon={<BarChart3 aria-hidden="true" className="size-10" />}
                title="No chart data"
            />
        );
    }

    return (
        <Card>
            <CardHeader>
                <div className="flex items-start justify-between gap-3">
                    <div>
                        <CardTitle>Reports by status</CardTitle>
                        <CardDescription>Distribution of weekly reports across the workflow.</CardDescription>
                    </div>
                    <Badge intent="primary">{formatNumber(total)} total</Badge>
                </div>
            </CardHeader>
            <CardContent>
                <div aria-label="Reports by status chart" className="grid gap-4" role="img">
                    {statusEntries.map(([status, count]) => {
                        const percentage = total > 0 ? (count / total) * 100 : 0;
                        const width = Math.max(percentage, count > 0 ? 4 : 0);

                        return (
                            <div className="grid gap-2" key={status}>
                                <div className="flex items-center justify-between gap-3 text-sm">
                                    <div className="flex items-center gap-2">
                                        {isReportStatusValue(status) ? (
                                            <ReportStatusBadge status={status} />
                                        ) : (
                                            <Badge intent="neutral">{getStatusLabel(status)}</Badge>
                                        )}
                                        <span className="text-muted-foreground">{formatNumber(count)}</span>
                                    </div>
                                    <span className="font-medium text-foreground">{formatPercent(Math.round(percentage))}</span>
                                </div>
                                <div className="h-2.5 rounded-full bg-muted">
                                    <div
                                        className={`h-2.5 rounded-full transition-all ${getStatusBarClass(status)}`}
                                        style={{ width: `${width}%` }}
                                    />
                                </div>
                            </div>
                        );
                    })}
                </div>
            </CardContent>
        </Card>
    );
}

function RecentReportsSection({ loading, reports }: { loading: boolean; reports: readonly WeeklyReport[] }) {
    const navigate = useNavigate();

    if (loading) {
        return <SectionCardSkeleton />;
    }

    return (
        <section className="grid gap-4">
            <SectionHeader
                actions={
                    <Button onClick={() => navigate('/reports')} rightIcon={<ArrowRight aria-hidden="true" className="size-4" />} size="sm" variant="outline">
                        View all
                    </Button>
                }
                description="Latest reports from the Report API."
                title="Recent reports"
            />
            {reports.length === 0 ? (
                <EmptyState
                    description="Recent weekly reports will appear here after reports are created."
                    icon={<FileText aria-hidden="true" className="size-10" />}
                    title="No recent reports"
                />
            ) : (
                <div className="grid gap-4 lg:grid-cols-2 xl:grid-cols-1 2xl:grid-cols-2">
                    {reports.slice(0, 6).map((report) => (
                        <ReportCard
                            description={getReportDescription(report)}
                            key={report.id}
                            meta={[
                                { label: 'Employee', value: getEmployeeName(report) },
                                { label: 'Department', value: report.department },
                                { label: 'Week', value: report.week },
                                { label: 'Updated', value: formatDate(report.updated_at) },
                            ]}
                            progress={getReportProgress(report.status.value)}
                            status={report.status.value}
                            subtitle={`${report.department} · ${formatDate(report.updated_at)}`}
                            title={getReportTitle(report)}
                        />
                    ))}
                </div>
            )}
        </section>
    );
}

function PendingApprovalsSection({ loading, reports }: { loading: boolean; reports: readonly WeeklyReport[] }) {
    const items: ApprovalTimelineItem[] = reports.slice(0, 6).map((report) => ({
        actor: getEmployeeName(report),
        description: `${report.department} report for week ${report.week} is waiting for workflow review.`,
        id: String(report.id),
        status: 'current',
        timestamp: formatDate(report.submitted_at ?? report.updated_at),
        title: report.status.label,
    }));

    if (loading) {
        return <SectionCardSkeleton />;
    }

    return (
        <section className="grid gap-4">
            <SectionHeader description="Submitted reports currently waiting for approval." title="Pending approvals" />
            {items.length === 0 ? (
                <EmptyState
                    description="Submitted reports awaiting approval will appear here."
                    icon={<GitPullRequest aria-hidden="true" className="size-10" />}
                    title="No pending approvals"
                />
            ) : (
                <ApprovalTimeline items={items} />
            )}
        </section>
    );
}

function buildActivityFeed(data: DashboardData | undefined): NotificationListEntry[] {
    const reports = data?.recent_reports ?? [];

    return reports.slice(0, 8).map((report) => ({
        description: `${getEmployeeName(report)} · ${report.department} · Week ${report.week}`,
        icon: <FileText aria-hidden="true" className="size-5" />,
        id: String(report.id),
        time: formatRelativeTime(report.updated_at ?? report.created_at),
        title: `${report.status.label} report update`,
        unread: report.status.value === 'submitted',
    }));
}

function ActivityFeedSection({ data, loading }: { data?: DashboardData; loading: boolean }) {
    const notifications = useMemo(() => buildActivityFeed(data), [data]);

    if (loading) {
        return <SectionCardSkeleton />;
    }

    return (
        <section className="grid gap-4">
            <SectionHeader description="Recent report activity derived from Dashboard API report records." title="Activity feed" />
            <NotificationList
                emptyDescription="Activity appears here when reports are created or updated."
                emptyTitle="No recent activity"
                notifications={notifications}
            />
        </section>
    );
}

function QuickActionsSection() {
    const navigate = useNavigate();
    const actions = [
        {
            description: 'Open the reports workspace.',
            icon: <FilePlus2 aria-hidden="true" className="size-5" />,
            label: 'Open reports',
            to: '/reports',
            variant: 'primary' as const,
        },
        {
            description: 'Review submitted reports.',
            icon: <GitPullRequest aria-hidden="true" className="size-5" />,
            label: 'Review workflow',
            to: '/workflow',
            variant: 'outline' as const,
        },
        {
            description: 'Inspect reporting trends.',
            icon: <BarChart3 aria-hidden="true" className="size-5" />,
            label: 'View analytics',
            to: '/analytics',
            variant: 'outline' as const,
        },
        {
            description: 'Open AI-assisted reporting.',
            icon: <Sparkles aria-hidden="true" className="size-5" />,
            label: 'Open AI',
            to: '/ai',
            variant: 'outline' as const,
        },
    ];

    return (
        <Card>
            <CardHeader>
                <CardTitle>Quick actions</CardTitle>
                <CardDescription>Navigation shortcuts for the reporting workflow.</CardDescription>
            </CardHeader>
            <CardContent className="grid gap-3">
                {actions.map((action) => (
                    <div className="rounded-2xl border bg-background p-3" key={action.to}>
                        <div className="flex items-start gap-3">
                            <span className="rounded-xl bg-muted p-2 text-muted-foreground">{action.icon}</span>
                            <div className="min-w-0 flex-1">
                                <p className="text-sm font-medium text-foreground">{action.label}</p>
                                <p className="mt-1 text-sm text-muted-foreground">{action.description}</p>
                            </div>
                        </div>
                        <Button
                            className="mt-3 w-full"
                            onClick={() => navigate(action.to)}
                            rightIcon={<ArrowRight aria-hidden="true" className="size-4" />}
                            size="sm"
                            variant={action.variant}
                        >
                            {action.label}
                        </Button>
                    </div>
                ))}
            </CardContent>
        </Card>
    );
}

export function DashboardPage() {
    const navigate = useNavigate();

    useEffect(() => {
        document.title = `Dashboard - ${appConfig.name}`;
    }, []);

    const dashboardQuery = useQuery({
        queryFn: ({ signal }) => getDashboard({ signal }),
        queryKey: dashboardQueryKeys.detail(),
        select: (response) => response.data,
    });

    const reportsQuery = useQuery({
        queryFn: ({ signal }) => listReports({ page: 1, signal }),
        queryKey: reportsQueryKeys.list({ page: 1 }),
        select: (response) => response.data,
    });

    const dashboardData = dashboardQuery.data;
    const recentReports = reportsQuery.data ?? dashboardData?.recent_reports ?? [];
    const isInitialDashboardLoading = dashboardQuery.isLoading;
    const isInitialReportsLoading = reportsQuery.isLoading && !dashboardData;
    const isRefreshing = (dashboardQuery.isFetching || reportsQuery.isFetching) && !isInitialDashboardLoading && !isInitialReportsLoading;

    const refreshDashboard = () => {
        void dashboardQuery.refetch();
        void reportsQuery.refetch();
    };

    return (
        <PageContainer
            actions={
                <div className="flex flex-wrap items-center gap-2">
                    <Button
                        leftIcon={<RefreshCw aria-hidden="true" className="size-4" />}
                        loading={isRefreshing}
                        onClick={refreshDashboard}
                        variant="outline"
                    >
                        Refresh
                    </Button>
                    <Button onClick={() => navigate('/reports')} rightIcon={<ArrowRight aria-hidden="true" className="size-4" />}>
                        Open reports
                    </Button>
                </div>
            }
            description="Live overview of the weekly reporting workflow, approvals, and report generation progress."
            eyebrow="ReportFlow"
            title="Dashboard"
        >
            <div className="grid gap-6">
                {dashboardQuery.isError && (
                    <DashboardErrorAlert error={dashboardQuery.error} onRetry={() => void dashboardQuery.refetch()} title="Dashboard API unavailable" />
                )}
                {reportsQuery.isError && (
                    <DashboardErrorAlert error={reportsQuery.error} onRetry={() => void reportsQuery.refetch()} title="Report API unavailable" />
                )}

                <section className="grid gap-4" aria-labelledby="dashboard-kpis">
                    <SectionHeader description="Real-time workflow totals from the Dashboard API." title={<span id="dashboard-kpis">KPI overview</span>} />
                    <KpiSection loading={isInitialDashboardLoading} statistics={dashboardData?.statistics} />
                </section>

                <section className="grid gap-6 xl:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)]" aria-label="Dashboard metrics and charts">
                    <OperationalMetrics charts={dashboardData?.charts} loading={isInitialDashboardLoading} statistics={dashboardData?.statistics} />
                    <ReportsByStatusChart charts={dashboardData?.charts} loading={isInitialDashboardLoading} />
                </section>

                <section className="grid gap-6 xl:grid-cols-[minmax(0,1.35fr)_minmax(320px,0.65fr)]" aria-label="Reports and approvals">
                    <RecentReportsSection loading={isInitialReportsLoading} reports={recentReports} />
                    <PendingApprovalsSection loading={isInitialDashboardLoading} reports={dashboardData?.pending_reports ?? []} />
                </section>

                <section className="grid gap-6 xl:grid-cols-[minmax(0,1fr)_minmax(300px,0.45fr)]" aria-label="Activity and actions">
                    <ActivityFeedSection data={dashboardData} loading={isInitialDashboardLoading} />
                    <QuickActionsSection />
                </section>
            </div>
        </PageContainer>
    );
}
