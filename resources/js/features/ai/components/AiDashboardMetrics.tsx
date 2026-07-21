import { Activity, CheckCircle2, Clock3, Sparkles } from 'lucide-react';

import { MetricCard, StatCard } from '@/components/business/dashboard';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';
import type { AiActionUsage, AiDashboard } from '@/types';

import { formatAiAction } from '../utils/ai-utils';

export type AiDashboardMetricsProps = {
    dashboard: AiDashboard;
};

function TopActions({ actions }: { actions: AiActionUsage[] }) {
    if (actions.length === 0) {
        return (
            <p className="text-sm text-muted-foreground">
                No action usage has been logged yet.
            </p>
        );
    }

    return (
        <div className="grid gap-3">
            {actions.slice(0, 5).map((item) => (
                <div className="flex items-center justify-between gap-3 rounded-xl bg-muted/60 p-3" key={item.action}>
                    <span className="text-sm font-medium text-foreground">{item.label || formatAiAction(item.action)}</span>
                    <span className="text-sm text-muted-foreground">{item.total}</span>
                </div>
            ))}
        </div>
    );
}

export function AiDashboardMetrics({ dashboard }: AiDashboardMetricsProps) {
    const configuredProviders = dashboard.providers.filter((provider) => provider.configured).length;

    return (
        <>
            <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <StatCard
                    icon={<Sparkles aria-hidden="true" className="size-5" />}
                    title="Total generations"
                    value={dashboard.total_generations}
                />
                <StatCard
                    icon={<Clock3 aria-hidden="true" className="size-5" />}
                    title="Generated today"
                    value={dashboard.today_generations}
                />
                <MetricCard
                    helperText="Available from configured backend metadata."
                    icon={<Activity aria-hidden="true" className="size-5" />}
                    label="Available actions"
                    value={dashboard.available_actions.length}
                />
                <MetricCard
                    helperText="Failure tracking is not exposed by the current AI API."
                    icon={<CheckCircle2 aria-hidden="true" className="size-5" />}
                    label="Success rate"
                    value="Logged only"
                />
            </div>

            <div className="grid gap-6 xl:grid-cols-[1fr_24rem]">
                <Card>
                    <CardHeader>
                        <CardTitle>Action usage</CardTitle>
                        <CardDescription>Successful AI generations grouped by action.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <TopActions actions={dashboard.by_action} />
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>Provider readiness</CardTitle>
                        <CardDescription>Configured providers exposed by the backend.</CardDescription>
                    </CardHeader>
                    <CardContent className="grid gap-3">
                        <div className="rounded-xl bg-muted/60 p-4">
                            <p className="text-3xl font-semibold text-foreground">{configuredProviders}/{dashboard.providers.length}</p>
                            <p className="mt-1 text-sm text-muted-foreground">providers configured</p>
                        </div>
                        <p className="text-sm leading-6 text-muted-foreground">
                            API keys are never exposed to React. The frontend only receives provider metadata.
                        </p>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
