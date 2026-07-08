import { Activity, FileClock } from 'lucide-react';

import { Card, CardContent, CardDescription, CardHeader, CardTitle, EmptyState, Pagination, Skeleton } from '@/components/ui';
import type { EmployeeActivity } from '@/types';
import { formatEmployeeDate } from '../utils/employee-utils';

export type EmployeeActivityTimelineProps = {
    activities: readonly EmployeeActivity[];
    isLoading?: boolean;
    onPageChange?: (page: number) => void;
    page?: number;
    pageCount?: number;
};

export function EmployeeActivityTimeline({ activities, isLoading = false, onPageChange, page = 1, pageCount = 1 }: EmployeeActivityTimelineProps) {
    return (
        <Card>
            <CardHeader>
                <CardTitle>Employee activity timeline</CardTitle>
                <CardDescription>Workflow activity returned by the Employee Activity API endpoint.</CardDescription>
            </CardHeader>
            <CardContent className="grid gap-4">
                {isLoading ? (
                    <div className="grid gap-3">
                        <Skeleton className="h-24" />
                        <Skeleton className="h-24" />
                        <Skeleton className="h-24" />
                    </div>
                ) : activities.length === 0 ? (
                    <EmptyState description="Workflow activity will appear after this employee's reports move through the approval flow." icon={<FileClock aria-hidden="true" className="size-10" />} title="No employee activity" />
                ) : (
                    <>
                        <ol className="relative grid gap-4 border-l pl-5" aria-label="Employee workflow activity">
                            {activities.map((activity) => (
                                <li className="relative" key={activity.id}>
                                    <span aria-hidden="true" className="absolute -left-[1.65rem] top-1.5 size-3 rounded-full border-2 border-surface bg-primary" />
                                    <article className="rounded-2xl border bg-background p-4">
                                        <div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                            <div className="min-w-0">
                                                <h3 className="flex items-center gap-2 text-sm font-semibold text-foreground">
                                                    <Activity aria-hidden="true" className="size-4 text-primary" />
                                                    {activity.description}
                                                </h3>
                                                <p className="mt-1 text-xs text-muted-foreground">
                                                    {activity.causer?.name ?? activity.causer?.email ?? 'System'} · {formatEmployeeDate(activity.created_at)}
                                                </p>
                                            </div>
                                            {activity.report_id && <span className="text-xs font-medium text-muted-foreground">Report #{activity.report_id}</span>}
                                        </div>
                                    </article>
                                </li>
                            ))}
                        </ol>
                        {onPageChange && pageCount > 1 && <Pagination className="justify-center" onPageChange={onPageChange} page={page} pageCount={pageCount} />}
                    </>
                )}
            </CardContent>
        </Card>
    );
}