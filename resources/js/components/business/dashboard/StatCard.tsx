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
        <Card className="overflow-hidden bg-gradient-to-br from-white to-blue-50/40 dark:from-surface dark:to-blue-950/20">
            <CardHeader className="flex-row items-start justify-between gap-4">
                <div className="min-w-0">
                    <CardDescription>{title}</CardDescription>
                    <CardTitle className="mt-2 font-display text-3xl tracking-[-0.05em]">{value}</CardTitle>
                </div>
                {icon && <div className="rounded-2xl bg-primary/10 p-2.5 text-primary">{icon}</div>}
            </CardHeader>
            {(description || trend || action) && (
                <CardContent className="flex items-center justify-between gap-3 border-t border-border/60 bg-white/45 dark:bg-surface/40">
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
