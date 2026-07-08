import type { ReactNode } from 'react';

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui';

export type ReportSummaryItem = {
    label: string;
    value: ReactNode;
};

export type ReportSummaryCardProps = {
    items: readonly ReportSummaryItem[];
    title: string;
};

export function ReportSummaryCard({ items, title }: ReportSummaryCardProps) {
    return (
        <Card>
            <CardHeader>
                <CardTitle>{title}</CardTitle>
            </CardHeader>
            <CardContent>
                <dl className="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    {items.map((item) => (
                        <div className="rounded-xl border bg-background p-3" key={item.label}>
                            <dt className="text-xs font-medium uppercase tracking-wide text-muted-foreground">{item.label}</dt>
                            <dd className="mt-1 text-base font-semibold text-foreground">{item.value}</dd>
                        </div>
                    ))}
                </dl>
            </CardContent>
        </Card>
    );
}
