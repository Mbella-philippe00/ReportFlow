import { AlertCircle } from 'lucide-react';

import { Alert, Button, Modal } from '@/components/ui';
import type { ReportWorkflowAction, WeeklyReport } from '@/types';

import { getWorkflowActionCopy } from '../utils/workflow-utils';

export type WorkflowConfirmDialogProps = {
    action: Exclude<ReportWorkflowAction, 'reject'> | null;
    isPending?: boolean;
    onConfirm: () => void;
    onOpenChange: (open: boolean) => void;
    open: boolean;
    report: WeeklyReport | null;
};

export function WorkflowConfirmDialog({ action, isPending = false, onConfirm, onOpenChange, open, report }: WorkflowConfirmDialogProps) {
    if (!action || !report) {
        return null;
    }

    const copy = getWorkflowActionCopy(action, report);

    return (
        <Modal
            description={copy.description}
            footer={
                <>
                    <Button disabled={isPending} onClick={() => onOpenChange(false)} variant="outline">
                        Cancel
                    </Button>
                    <Button loading={isPending} onClick={onConfirm} variant="primary">
                        {copy.confirmLabel}
                    </Button>
                </>
            }
            onOpenChange={onOpenChange}
            open={open}
            size="sm"
            title={copy.title}
        >
            <Alert
                description="This action will update the backend workflow state and notify the affected users when the backend is configured to do so."
                icon={<AlertCircle aria-hidden="true" className="size-5" />}
                intent="info"
                title="Confirmation required"
            />
        </Modal>
    );
}