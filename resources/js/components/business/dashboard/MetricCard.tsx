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
        <Card elevation="none">
            <CardContent className="flex items-center gap-4 p-4">
                {icon && <div className="rounded-xl bg-muted p-2 text-muted-foreground">{icon}</div>}
                <div className="min-w-0 flex-1">
                    <p className="text-sm text-muted-foreground">{label}</p>
                    <div className="mt-1 flex items-center gap-2">
                        <p className="truncate text-xl font-semibold text-surface-foreground">{value}</p>
                        <Badge intent={intent}>{intent}</Badge>
                    </div>
                    {helperText && <p className="mt-1 text-xs text-muted-foreground">{helperText}</p>}
                </div>
            </CardContent>
        </Card>
    );
}
