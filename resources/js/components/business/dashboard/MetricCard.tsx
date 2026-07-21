import type { ReactNode } from 'react';

import { Badge, Card, CardContent } from '@/components/ui';

export type MetricCardIntent = 'danger' | 'neutral' | 'primary' | 'success' | 'warning';

export type MetricCardProps = {
    helperText?: ReactNode;
    icon?: ReactNode;
    intent?: MetricCardIntent;
    label: string;
    value: ReactNode;
};

export function MetricCard({ helperText, icon, intent = 'neutral', label, value }: MetricCardProps) {
    return (
        <Card className="bg-white/70 dark:bg-surface/70" elevation="none">
            <CardContent className="flex items-center gap-4 p-4">
                {icon && <div className="rounded-2xl bg-primary/10 p-2.5 text-primary">{icon}</div>}
                <div className="min-w-0 flex-1">
                    <p className="text-sm text-muted-foreground">{label}</p>
                    <div className="mt-1 flex items-center gap-2">
                        <p className="truncate font-display text-2xl font-semibold tracking-[-0.04em] text-surface-foreground">{value}</p>
                        <Badge intent={intent}>{intent}</Badge>
                    </div>
                    {helperText && <p className="mt-1 text-xs text-muted-foreground">{helperText}</p>}
                </div>
            </CardContent>
        </Card>
    );
}
