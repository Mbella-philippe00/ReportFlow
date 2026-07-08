import { Minus, TrendingDown, TrendingUp } from 'lucide-react';

import { Badge } from '@/components/ui';
import { cn } from '@/utils/cn';

export type TrendDirection = 'down' | 'neutral' | 'up';

export type TrendIndicatorProps = {
    className?: string;
    direction: TrendDirection;
    label?: string;
    value: number | string;
};

const trendConfig = {
    down: {
        icon: TrendingDown,
        intent: 'danger',
        label: 'Decreasing trend',
    },
    neutral: {
        icon: Minus,
        intent: 'neutral',
        label: 'Neutral trend',
    },
    up: {
        icon: TrendingUp,
        intent: 'success',
        label: 'Increasing trend',
    },
} as const;

export function TrendIndicator({ className, direction, label, value }: TrendIndicatorProps) {
    const config = trendConfig[direction];
    const Icon = config.icon;
    const accessibleLabel = `${label ?? config.label}: ${value}`;

    return (
        <Badge aria-label={accessibleLabel} className={cn('gap-1.5', className)} intent={config.intent}>
            <Icon aria-hidden="true" className="size-3.5" />
            <span>{value}</span>
        </Badge>
    );
}
