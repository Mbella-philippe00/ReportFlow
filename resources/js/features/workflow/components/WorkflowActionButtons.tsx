import { CheckCircle2, Send, ShieldCheck, XCircle } from 'lucide-react';

import { Button } from '@/components/ui';
import type { ReportWorkflowAction, WeeklyReport } from '@/types';
import type { AuthUser } from '@/types';

import { getWorkflowActionCopy, getWorkflowCapabilities } from '../utils/workflow-utils';

export type WorkflowActionButtonsProps = {
    onAction: (action: ReportWorkflowAction, report: WeeklyReport) => void;
    pendingAction?: ReportWorkflowAction | null;
    report: WeeklyReport;
    user: AuthUser | null;
};

const actionIcons = {
    approve: CheckCircle2,
    'final-approve': ShieldCheck,
    reject: XCircle,
    submit: Send,
} as const;

const actionVariants = {
    approve: 'secondary',
    'final-approve': 'primary',
    reject: 'danger',
    submit: 'primary',
} as const;

export function WorkflowActionButtons({ onAction, pendingAction = null, report, user }: WorkflowActionButtonsProps) {
    const capabilities = getWorkflowCapabilities(report, user);

    if (capabilities.allowedActions.length === 0) {
        return null;
    }

    return (
        <div className="flex flex-wrap items-center gap-2" aria-label="Workflow actions">
            {capabilities.allowedActions.map((action) => {
                const Icon = actionIcons[action];
                const copy = getWorkflowActionCopy(action, report);

                return (
                    <Button
                        key={action}
                        leftIcon={<Icon aria-hidden="true" className="size-4" />}
                        loading={pendingAction === action}
                        onClick={() => onAction(action, report)}
                        size="sm"
                        variant={actionVariants[action]}
                    >
                        {copy.label}
                    </Button>
                );
            })}
        </div>
    );
}