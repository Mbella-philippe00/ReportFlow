import { History, MoveRight } from 'lucide-react';

import { ApprovalStatusBadge } from '@/components/business/workflow/ApprovalStatusBadge';
import { Button, Card, CardContent, CardDescription, CardHeader, CardTitle, EmptyState } from '@/components/ui';
import { formatReportDate } from '@/features/reports/utils/report-utils';
import type { WeeklyReport } from '@/types';

import { buildWorkflowHistory } from '../utils/workflow-utils';

export type WorkflowHistoryProps = {
    onOpen: (report: WeeklyReport) => void;
    reports: readonly WeeklyReport[];
};

export function WorkflowHistory({ onOpen, reports }: WorkflowHistoryProps) {
    const events = buildWorkflowHistory(reports).slice(0, 12);

    return (
        <Card>
            <CardHeader>
                <CardTitle>Workflow history</CardTitle>
                <CardDescription>Recent workflow events from reports returned by the backend.</CardDescription>
            </CardHeader>
            <CardContent>
                {events.length === 0 ? (
                    <EmptyState description="Workflow events will appear after reports move through the backend workflow." icon={<History aria-hidden="true" className="size-10" />} title="No workflow history" />
                ) : (
                    <ol className="grid gap-3" aria-label="Workflow history">
                        {events.map((event) => (
                            <li className="rounded-2xl border bg-background p-4" key={event.id}>
                                <div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div className="min-w-0">
                                        <div className="flex flex-wrap items-center gap-2">
                                            <h3 className="text-sm font-semibold text-foreground">{event.title}</h3>
                                            <ApprovalStatusBadge status={event.status} />
                                        </div>
                                        <p className="mt-1 text-sm text-muted-foreground">{event.description}</p>
                                        <p className="mt-2 text-xs text-muted-foreground">
                                            {event.actor} · {formatReportDate(event.timestamp)}
                                        </p>
                                    </div>
                                    <Button onClick={() => onOpen(event.report)} rightIcon={<MoveRight aria-hidden="true" className="size-4" />} size="sm" variant="outline">
                                        Open
                                    </Button>
                                </div>
                            </li>
                        ))}
                    </ol>
                )}
            </CardContent>
        </Card>
    );
}