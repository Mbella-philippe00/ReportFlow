import type { ReactNode } from 'react';

import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';
import { TrendIndicator } from '@/components/business/dashboard/TrendIndicator';
import type { TrendDirection } from '@/components/business/dashboard/TrendIndicator';

export type StatCardProps = {
    action?: ReactNode;
    description?: ReactNode;
    icon?: ReactNode;
    title: string;
    trend?: {
        direction: TrendDirection;
        label?: string;
        value: number | string;
    };
    value: ReactNode;
};

export function StatCard({ action, description, icon, title, trend, value }: StatCardProps) {
    return (
        <Card>
            <CardHeader className="flex-row items-start justify-between gap-4">
                <div className="min-w-0">
                    <CardDescription>{title}</CardDescription>
                    <CardTitle className="mt-2 text-2xl">{value}</CardTitle>
                </div>
                {icon && <div className="rounded-xl bg-muted p-2 text-muted-foreground">{icon}</div>}
            </CardHeader>
            {(description || trend || action) && (
                <CardContent className="flex items-center justify-between gap-3">
                    <div className="min-w-0 text-sm text-muted-foreground">{description}</div>
                    <div className="flex shrink-0 items-center gap-2">
                        {trend && <TrendIndicator direction={trend.direction} label={trend.label} value={trend.value} />}
                        {action}
                    </div>
                </CardContent>
            )}
        </Card>
    );
}
