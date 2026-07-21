import { CheckCircle2, Clock3, FileText, GitPullRequest, Percent, Presentation, XCircle } from 'lucide-react';

import { StatCard } from '@/components/business';
import { Badge, Card, CardContent, CardDescription, CardHeader, CardTitle, Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui';
import type { AnalyticsActivity, AnalyticsDistributionItem, AnalyticsOverview, AnalyticsStatusDistributionItem } from '@/types';

import {
    formatAnalyticsDateTime,
    formatAnalyticsNumber,
    formatAnalyticsPercent,
    formatRelativeTime,
    getAnalyticsErrorMessage,
    getStatusBadgeIntent,
    getStatusChartColor,
} from '../utils/analytics-utils';

export function AnalyticsKpiGrid({ overview }: { overview: AnalyticsOverview }) {
    return (
        <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <StatCard
                description="All reports matching the selected filters."
                icon={<FileText aria-hidden="true" className="size-5" />}
                title="Total reports"
                value={formatAnalyticsNumber(overview.total_reports)}
            />
            <StatCard
                description="Submitted or under-review reports waiting in workflow."
                icon={<GitPullRequest aria-hidden="true" className="size-5" />}
                title="Pending reports"
                value={formatAnalyticsNumber(overview.pending_reports)}
            />
            <StatCard
                description="Approved reports compared with approved plus rejected reports."
                icon={<Percent aria-hidden="true" className="size-5" />}
                title="Validation rate"
                value={formatAnalyticsPercent(overview.validation_rate)}
            />
            <StatCard
                description="Average time from submission to approval or rejection."
                icon={<Clock3 aria-hidden="true" className="size-5" />}
                title="Avg approval time"
                value={overview.average_approval_time.human}
            />
            <StatCard
                description="Reports that moved beyond draft."
                icon={<CheckCircle2 aria-hidden="true" className="size-5" />}
                title="Completion rate"
                value={formatAnalyticsPercent(overview.completion_rate)}
            />
            <StatCard
                description="Reports approved and locked read-only."
                icon={<Presentation aria-hidden="true" className="size-5" />}
                title="Approved reports"
                value={formatAnalyticsNumber(overview.generated_reports)}
            />
            <StatCard
                description="Reports rejected by the workflow."
                icon={<XCircle aria-hidden="true" className="size-5" />}
                title="Rejected reports"
                value={formatAnalyticsNumber(overview.rejected_reports)}
            />
            <StatCard
                description="Reports currently submitted to managers."
                icon={<Clock3 aria-hidden="true" className="size-5" />}
                title="Submitted reports"
                value={formatAnalyticsNumber(overview.submitted_reports)}
            />
        </div>
    );
}

export function StatusDistributionList({ statuses }: { statuses: readonly AnalyticsStatusDistributionItem[] }) {
    const total = statuses.reduce((sum, status) => sum + status.count, 0);

    return (
        <div className="grid gap-3">
            {statuses.map((status) => {
                const percentage = total > 0 ? (status.count / total) * 100 : 0;
                const width = status.count > 0 ? Math.max(percentage, 4) : 0;

                return (
                    <div className="grid gap-2" key={status.value}>
                        <div className="flex items-center justify-between gap-3 text-sm">
                            <Badge intent={getStatusBadgeIntent(status.color)}>{status.label}</Badge>
                            <span className="font-medium text-foreground">{formatAnalyticsNumber(status.count)}</span>
                        </div>
                        <div className="h-2.5 rounded-full bg-muted">
                            <div className="h-2.5 rounded-full" style={{ backgroundColor: getStatusChartColor(status.value), width: `${width}%` }} />
                        </div>
                    </div>
                );
            })}
        </div>
    );
}

export function DistributionTable({ items, labelHeader = 'Label', valueHeader = 'Total' }: { items: readonly AnalyticsDistributionItem[]; labelHeader?: string; valueHeader?: string }) {
    return (
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>{labelHeader}</TableHead>
                    <TableHead className="text-right">{valueHeader}</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                {items.map((item) => (
                    <TableRow key={item.label}>
                        <TableCell>{item.label}</TableCell>
                        <TableCell className="text-right font-medium">{formatAnalyticsNumber(item.total)}</TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}

export function ProgressMetric({ label, value }: { label: string; value: number }) {
    const normalized = Math.min(100, Math.max(0, value));

    return (
        <div className="grid gap-2">
            <div className="flex items-center justify-between gap-3 text-sm">
                <span className="text-muted-foreground">{label}</span>
                <span className="font-medium text-foreground">{formatAnalyticsPercent(value)}</span>
            </div>
            <div aria-label={`${label}: ${normalized}%`} aria-valuemax={100} aria-valuemin={0} aria-valuenow={normalized} className="h-2.5 rounded-full bg-muted" role="progressbar">
                <div className="h-2.5 rounded-full bg-primary" style={{ width: `${normalized}%` }} />
            </div>
        </div>
    );
}

export function ActivityTimeline({ activities }: { activities: readonly AnalyticsActivity[] }) {
    return (
        <Card>
            <CardHeader>
                <CardTitle>Recent analytical activity</CardTitle>
                <CardDescription>Workflow activity from the backend activity log.</CardDescription>
            </CardHeader>
            <CardContent>
                <ol className="relative grid gap-4 border-l pl-5">
                    {activities.map((activity) => (
                        <li className="relative" key={activity.id}>
                            <span className="absolute -left-[1.65rem] top-1 size-3 rounded-full border-2 border-surface bg-primary" />
                            <div className="rounded-2xl border bg-muted/30 p-4">
                                <div className="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <p className="font-medium text-foreground">{activity.description}</p>
                                        <p className="mt-1 text-sm text-muted-foreground">
                                            {activity.causer?.name ?? activity.causer?.email ?? 'System'} ? Report #{activity.report_id ?? 'N/A'}
                                        </p>
                                    </div>
                                    <Badge intent="neutral">{formatRelativeTime(activity.occurred_at)}</Badge>
                                </div>
                                <p className="mt-3 text-xs text-muted-foreground">{formatAnalyticsDateTime(activity.occurred_at)}</p>
                            </div>
                        </li>
                    ))}
                </ol>
            </CardContent>
        </Card>
    );
}

export function AnalyticsQueryFailure({ error }: { error: unknown }) {
    return <span>{getAnalyticsErrorMessage(error)}</span>;
}
