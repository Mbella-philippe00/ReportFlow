import { Badge } from '@/components/ui';

export type ReportPriority = 'critical' | 'high' | 'low' | 'medium';

export type ReportPriorityBadgeProps = {
    label?: string;
    priority: ReportPriority;
};

const priorityConfig: Record<ReportPriority, { intent: 'danger' | 'neutral' | 'success' | 'warning'; label: string }> = {
    critical: { intent: 'danger', label: 'Critical' },
    high: { intent: 'warning', label: 'High' },
    low: { intent: 'success', label: 'Low' },
    medium: { intent: 'neutral', label: 'Medium' },
};

export function ReportPriorityBadge({ label, priority }: ReportPriorityBadgeProps) {
    const config = priorityConfig[priority];

    return <Badge intent={config.intent}>{label ?? config.label}</Badge>;
}
