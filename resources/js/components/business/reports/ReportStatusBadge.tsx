import { Badge } from '@/components/ui';
import type { ReportStatusValue } from '@/types';

export type ReportStatusBadgeProps = {
    label?: string;
    status: ReportStatusValue | 'archived' | 'pending';
};

const statusConfig: Record<ReportStatusBadgeProps['status'], { intent: 'danger' | 'neutral' | 'primary' | 'success' | 'warning'; label: string }> = {
    approved: { intent: 'success', label: 'Approved' },
    archived: { intent: 'neutral', label: 'Archived' },
    draft: { intent: 'neutral', label: 'Draft' },
    pending: { intent: 'warning', label: 'Pending' },
    rejected: { intent: 'danger', label: 'Rejected' },
    submitted: { intent: 'warning', label: 'Submitted' },
    under_review: { intent: 'primary', label: 'Under Review' },
};

export function ReportStatusBadge({ label, status }: ReportStatusBadgeProps) {
    const config = statusConfig[status];
    const resolvedLabel = label ?? config.label;

    return <Badge aria-label={`Report status: ${resolvedLabel}`} intent={config.intent}>{resolvedLabel}</Badge>;
}
