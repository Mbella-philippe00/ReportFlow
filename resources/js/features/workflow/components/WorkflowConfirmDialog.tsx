import { AlertCircle } from 'lucide-react';
import { useEffect, useState } from 'react';

import { Alert, Button, Modal, Textarea } from '@/components/ui';
import type { ReportWorkflowAction, WeeklyReport } from '@/types';

import { getWorkflowActionCopy } from '../utils/workflow-utils';

export type WorkflowConfirmDialogProps = {
    action: Exclude<ReportWorkflowAction, 'reject'> | null;
    isPending?: boolean;
    onConfirm: (comment?: string) => void;
    onOpenChange: (open: boolean) => void;
    open: boolean;
    report: WeeklyReport | null;
};

export function WorkflowConfirmDialog({ action, isPending = false, onConfirm, onOpenChange, open, report }: WorkflowConfirmDialogProps) {
    const [comment, setComment] = useState('');
    const [error, setError] = useState<string | undefined>();

    useEffect(() => {
        if (open) {
            setComment('');
            setError(undefined);
        }
    }, [open]);

    if (!action || !report) {
        return null;
    }

    const copy = getWorkflowActionCopy(action, report);
    const requiresComment = action === 'approve';

    const submit = () => {
        const trimmedComment = comment.trim();

        if (trimmedComment.length > 1000) {
            setError('The manager comment must be 1000 characters or fewer.');
            return;
        }

        onConfirm(requiresComment && trimmedComment ? trimmedComment : undefined);
    };

    return (
        <Modal
            description={copy.description}
            footer={
                <>
                    <Button disabled={isPending} onClick={() => onOpenChange(false)} variant="outline">
                        Cancel
                    </Button>
                    <Button loading={isPending} onClick={submit} variant="primary">
                        {copy.confirmLabel}
                    </Button>
                </>
            }
            onOpenChange={onOpenChange}
            open={open}
            size={requiresComment ? 'md' : 'sm'}
            title={copy.title}
        >
            <div className="grid gap-4">
                <Alert
                    description="This action updates the backend workflow state, logs activity, and notifies affected users."
                    icon={<AlertCircle aria-hidden="true" className="size-5" />}
                    intent="info"
                    title="Confirmation required"
                />
                {requiresComment && (
                    <>
                        <Textarea
                            error={error}
                            label="Manager comment"
                            maxLength={1000}
                            onChange={(event) => {
                                setComment(event.target.value);
                                setError(undefined);
                            }}
                            placeholder="Summarize review context for final approvers and the timeline."
                            value={comment}
                        />
                        <p className="text-xs text-muted-foreground">{comment.trim().length}/1000 characters</p>
                    </>
                )}
            </div>
        </Modal>
    );
}
