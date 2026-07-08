import { Badge } from '@/components/ui';
import type { ReportStatusValue } from '@/types';

export type ReportStatusBadgeProps = {
    label?: string;
    status: ReportStatusValue | 'archived' | 'approved' | 'pending';
};

const statusConfig: Record<ReportStatusBadgeProps['status'], { intent: 'danger' | 'neutral' | 'primary' | 'success' | 'warning'; label: string }> = {
    approved: { intent: 'success', label: 'Approved' },
    archived: { intent: 'neutral', label: 'Archived' },
    draft: { intent: 'neutral', label: 'Draft' },
    generated: { intent: 'primary', label: 'Generated' },
    manager_approved: { intent: 'success', label: 'Manager approved' },
    pending: { intent: 'warning', label: 'Pending' },
    rejected: { intent: 'danger', label: 'Rejected' },
    submitted: { intent: 'warning', label: 'Submitted' },
};

export function ReportStatusBadge({ label, status }: ReportStatusBadgeProps) {
    const config = statusConfig[status];

    return <Badge intent={config.intent}>{label ?? config.label}</Badge>;
}
