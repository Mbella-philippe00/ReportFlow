import type { CSSProperties, ReactNode } from 'react';

import { Badge, Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';

import { formatAnalyticsNumber, formatAnalyticsPercent, getChartPaletteColor } from '../utils/analytics-utils';

export type ChartDatum = {
    color?: string;
    label: string;
    value: number;
};

export type ChartCardProps = {
    badge?: ReactNode;
    children: ReactNode;
    description?: string;
    title: string;
};

export function ChartCard({ badge, children, description, title }: ChartCardProps) {
    return (
        <Card>
            <CardHeader>
                <div className="flex items-start justify-between gap-3">
                    <div>
                        <CardTitle>{title}</CardTitle>
                        {description && <CardDescription>{description}</CardDescription>}
                    </div>
                    {badge}
                </div>
            </CardHeader>
            <CardContent>{children}</CardContent>
        </Card>
    );
}

export function BarChart({ ariaLabel, data }: { ariaLabel: string; data: readonly ChartDatum[] }) {
    const maxValue = Math.max(...data.map((item) => item.value), 1);

    return (
        <div aria-label={ariaLabel} className="grid gap-3" role="img">
            {data.map((item, index) => {
                const width = item.value > 0 ? Math.max((item.value / maxValue) * 100, 4) : 0;
                const color = item.color ?? getChartPaletteColor(index);

                return (
                    <div className="grid gap-1.5" key={`${item.label}-${index}`}>
                        <div className="flex items-center justify-between gap-3 text-sm">
                            <span className="truncate text-muted-foreground">{item.label}</span>
                            <span className="font-medium text-foreground">{formatAnalyticsNumber(item.value)}</span>
                        </div>
                        <div className="h-2.5 rounded-full bg-muted">
                            <div className="h-2.5 rounded-full transition-all" style={{ backgroundColor: color, width: `${width}%` }} />
                        </div>
                    </div>
                );
            })}
        </div>
    );
}

export function LineChart({ ariaLabel, data, color = '#2563eb' }: { ariaLabel: string; color?: string; data: readonly ChartDatum[] }) {
    const width = 640;
    const height = 220;
    const padding = 24;
    const maxValue = Math.max(...data.map((item) => item.value), 1);
    const denominator = Math.max(data.length - 1, 1);
    const points = data.map((item, index) => {
        const x = data.length === 1 ? width / 2 : padding + (index / denominator) * (width - padding * 2);
        const y = height - padding - (item.value / maxValue) * (height - padding * 2);

        return { ...item, x, y };
    });
    const polyline = points.map((point) => `${point.x},${point.y}`).join(' ');

    return (
        <div aria-label={ariaLabel} className="grid gap-3" role="img">
            <svg className="h-56 w-full overflow-visible" preserveAspectRatio="none" viewBox={`0 0 ${width} ${height}`}>
                <line stroke="currentColor" strokeOpacity="0.12" x1={padding} x2={width - padding} y1={height - padding} y2={height - padding} />
                <polyline fill="none" points={polyline} stroke={color} strokeLinecap="round" strokeLinejoin="round" strokeWidth="4" />
                {points.map((point, index) => (
                    <circle cx={point.x} cy={point.y} fill={color} key={`${point.label}-${index}`} r="5" />
                ))}
            </svg>
            <div className="grid gap-2 sm:grid-cols-3">
                {points.slice(-3).map((point, index) => (
                    <div className="rounded-xl border bg-muted/40 p-3" key={`${point.label}-${index}`}>
                        <p className="text-xs text-muted-foreground">{point.label}</p>
                        <p className="mt-1 text-lg font-semibold text-foreground">{formatAnalyticsNumber(point.value)}</p>
                    </div>
                ))}
            </div>
        </div>
    );
}

export function AreaChart({ ariaLabel, data, color = '#16a34a' }: { ariaLabel: string; color?: string; data: readonly ChartDatum[] }) {
    const width = 640;
    const height = 220;
    const padding = 24;
    const maxValue = Math.max(...data.map((item) => item.value), 1);
    const denominator = Math.max(data.length - 1, 1);
    const points = data.map((item, index) => {
        const x = data.length === 1 ? width / 2 : padding + (index / denominator) * (width - padding * 2);
        const y = height - padding - (item.value / maxValue) * (height - padding * 2);

        return { ...item, x, y };
    });
    const line = points.map((point) => `${point.x},${point.y}`).join(' ');
    const area = `${padding},${height - padding} ${line} ${width - padding},${height - padding}`;

    return (
        <div aria-label={ariaLabel} role="img">
            <svg className="h-56 w-full overflow-visible" preserveAspectRatio="none" viewBox={`0 0 ${width} ${height}`}>
                <polygon fill={color} fillOpacity="0.16" points={area} />
                <polyline fill="none" points={line} stroke={color} strokeLinecap="round" strokeLinejoin="round" strokeWidth="4" />
                {points.map((point, index) => (
                    <circle cx={point.x} cy={point.y} fill={color} key={`${point.label}-${index}`} r="4" />
                ))}
            </svg>
        </div>
    );
}

export function DonutChart({ ariaLabel, data }: { ariaLabel: string; data: readonly ChartDatum[] }) {
    const total = data.reduce((sum, item) => sum + item.value, 0);
    let cursor = 0;
    const segments = data.map((item, index) => {
        const start = total > 0 ? (cursor / total) * 100 : 0;
        cursor += item.value;
        const end = total > 0 ? (cursor / total) * 100 : 0;
        const color = item.color ?? getChartPaletteColor(index);

        return `${color} ${start}% ${end}%`;
    });
    const style: CSSProperties = {
        background: total > 0 ? `conic-gradient(${segments.join(', ')})` : 'var(--color-muted)',
    };

    return (
        <div aria-label={ariaLabel} className="grid gap-5 lg:grid-cols-[auto_1fr] lg:items-center" role="img">
            <div className="relative mx-auto size-48 rounded-full" style={style}>
                <div className="absolute inset-8 grid place-items-center rounded-full bg-surface text-center shadow-soft">
                    <div>
                        <p className="text-2xl font-semibold text-foreground">{formatAnalyticsNumber(total)}</p>
                        <p className="text-xs text-muted-foreground">total</p>
                    </div>
                </div>
            </div>
            <div className="grid gap-2">
                {data.map((item, index) => {
                    const percentage = total > 0 ? (item.value / total) * 100 : 0;
                    const color = item.color ?? getChartPaletteColor(index);

                    return (
                        <div className="flex items-center justify-between gap-3 rounded-xl border bg-muted/30 p-3" key={`${item.label}-${index}`}>
                            <div className="flex min-w-0 items-center gap-2">
                                <span className="size-3 rounded-full" style={{ backgroundColor: color }} />
                                <span className="truncate text-sm text-foreground">{item.label}</span>
                            </div>
                            <div className="flex items-center gap-2">
                                <Badge intent="neutral">{formatAnalyticsPercent(Math.round(percentage))}</Badge>
                                <span className="text-sm font-medium text-foreground">{formatAnalyticsNumber(item.value)}</span>
                            </div>
                        </div>
                    );
                })}
            </div>
        </div>
    );
}
