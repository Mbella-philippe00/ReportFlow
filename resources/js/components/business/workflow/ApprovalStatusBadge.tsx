import { Badge } from '@/components/ui';

export type ApprovalStatus = 'approved' | 'current' | 'pending' | 'rejected' | 'skipped';

export type ApprovalStatusBadgeProps = {
    label?: string;
    status: ApprovalStatus;
};

const approvalStatusConfig: Record<ApprovalStatus, { intent: 'danger' | 'neutral' | 'primary' | 'success' | 'warning'; label: string }> = {
    approved: { intent: 'success', label: 'Approved' },
    current: { intent: 'primary', label: 'Current' },
    pending: { intent: 'warning', label: 'Pending' },
    rejected: { intent: 'danger', label: 'Rejected' },
    skipped: { intent: 'neutral', label: 'Skipped' },
};

export function ApprovalStatusBadge({ label, status }: ApprovalStatusBadgeProps) {
    const config = approvalStatusConfig[status];

    return <Badge intent={config.intent}>{label ?? config.label}</Badge>;
}
