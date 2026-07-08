import type { ReactNode } from 'react';

import { Button, Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui';
import { ReportPriorityBadge } from '@/components/business/reports/ReportPriorityBadge';
import type { ReportPriority } from '@/components/business/reports/ReportPriorityBadge';
import { ReportProgress } from '@/components/business/reports/ReportProgress';
import { ReportStatusBadge } from '@/components/business/reports/ReportStatusBadge';
import type { ReportStatusBadgeProps } from '@/components/business/reports/ReportStatusBadge';

export type ReportCardMetaItem = {
    label: string;
    value: ReactNode;
};

export type ReportCardProps = {
    actions?: ReactNode;
    description?: ReactNode;
    meta?: readonly ReportCardMetaItem[];
    onSelect?: () => void;
    priority?: ReportPriority;
    progress?: number;
    status: ReportStatusBadgeProps['status'];
    subtitle?: ReactNode;
    title: string;
};

export function ReportCard({ actions, description, meta, onSelect, priority, progress, status, subtitle, title }: ReportCardProps) {
    return (
        <Card>
            <CardHeader>
                <div className="flex items-start justify-between gap-4">
                    <div className="min-w-0">
                        <CardTitle>{title}</CardTitle>
                        {subtitle && <CardDescription>{subtitle}</CardDescription>}
                    </div>
                    <div className="flex shrink-0 flex-wrap justify-end gap-2">
                        <ReportStatusBadge status={status} />
                        {priority && <ReportPriorityBadge priority={priority} />}
                    </div>
                </div>
            </CardHeader>
            <CardContent className="grid gap-4">
                {description && <div className="text-sm leading-relaxed text-muted-foreground">{description}</div>}
                {progress !== undefined && <ReportProgress value={progress} />}
                {meta && meta.length > 0 && (
                    <dl className="grid gap-3 sm:grid-cols-2">
                        {meta.map((item) => (
                            <div className="rounded-xl bg-muted/60 p-3" key={item.label}>
                                <dt className="text-xs text-muted-foreground">{item.label}</dt>
                                <dd className="mt-1 text-sm font-medium text-foreground">{item.value}</dd>
                            </div>
                        ))}
                    </dl>
                )}
            </CardContent>
            {(actions || onSelect) && (
                <CardFooter className="justify-end">
                    {actions}
                    {onSelect && <Button onClick={onSelect}>Open report</Button>}
                </CardFooter>
            )}
        </Card>
    );
}
