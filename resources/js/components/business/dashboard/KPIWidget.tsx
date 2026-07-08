import type { ReactNode } from 'react';

import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';
import { TrendIndicator } from '@/components/business/dashboard/TrendIndicator';
import type { TrendDirection } from '@/components/business/dashboard/TrendIndicator';
import { cn } from '@/utils/cn';

export type KPIWidgetProps = {
    description?: ReactNode;
    footer?: ReactNode;
    progress?: number;
    target?: ReactNode;
    title: string;
    trend?: {
        direction: TrendDirection;
        label?: string;
        value: number | string;
    };
    value: ReactNode;
};

export function KPIWidget({ description, footer, progress, target, title, trend, value }: KPIWidgetProps) {
    const normalizedProgress = typeof progress === 'number' ? Math.min(100, Math.max(0, progress)) : undefined;

    return (
        <Card>
            <CardHeader>
                <div className="flex items-start justify-between gap-3">
                    <div>
                        <CardDescription>{title}</CardDescription>
                        <CardTitle className="mt-2 text-3xl">{value}</CardTitle>
                    </div>
                    {trend && <TrendIndicator direction={trend.direction} label={trend.label} value={trend.value} />}
                </div>
                {description && <p className="text-sm text-muted-foreground">{description}</p>}
            </CardHeader>
            {(normalizedProgress !== undefined || target || footer) && (
                <CardContent className="grid gap-3">
                    {normalizedProgress !== undefined && (
                        <div aria-label={`${normalizedProgress}% complete`} aria-valuemax={100} aria-valuemin={0} aria-valuenow={normalizedProgress} role="progressbar">
                            <div className="h-2 rounded-full bg-muted">
                                <div className={cn('h-2 rounded-full bg-primary transition-all')} style={{ width: `${normalizedProgress}%` }} />
                            </div>
                        </div>
                    )}
                    {target && <div className="text-sm text-muted-foreground">{target}</div>}
                    {footer}
                </CardContent>
            )}
        </Card>
    );
}
