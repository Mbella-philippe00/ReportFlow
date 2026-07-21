import { AlertTriangle } from 'lucide-react';
import { useEffect, useState } from 'react';

import { Alert, Button, Modal, Textarea } from '@/components/ui';
import type { WeeklyReport } from '@/types';

import { getReportTitle } from '@/features/reports/utils/report-utils';

export type RejectionDialogProps = {
    isPending?: boolean;
    onConfirm: (reason: string) => void;
    onOpenChange: (open: boolean) => void;
    open: boolean;
    report: WeeklyReport | null;
};

export function RejectionDialog({ isPending = false, onConfirm, onOpenChange, open, report }: RejectionDialogProps) {
    const [reason, setReason] = useState('');
    const [error, setError] = useState<string | undefined>();

    useEffect(() => {
        if (open) {
            setReason('');
            setError(undefined);
        }
    }, [open]);

    if (!report) {
        return null;
    }

    const submitRejection = () => {
        const trimmedReason = reason.trim();

        if (!trimmedReason) {
            setError('A rejection reason is required.');
            return;
        }

        if (trimmedReason.length > 1000) {
            setError('The rejection reason must be 1000 characters or fewer.');
            return;
        }

        onConfirm(trimmedReason);
    };

    return (
        <Modal
            description={`Reject ${getReportTitle(report)} and send the reason to the backend workflow.`}
            footer={
                <>
                    <Button disabled={isPending} onClick={() => onOpenChange(false)} variant="outline">
                        Cancel
                    </Button>
                    <Button loading={isPending} onClick={submitRejection} variant="danger">
                        Reject report
                    </Button>
                </>
            }
            onOpenChange={onOpenChange}
            open={open}
            size="md"
            title="Reject report"
        >
            <div className="grid gap-4">
                <Alert
                    description="The backend requires a rejection reason before moving a submitted or under-review report to rejected."
                    icon={<AlertTriangle aria-hidden="true" className="size-5" />}
                    intent="warning"
                    title="Reason required"
                />
                <Textarea
                    error={error}
                    label="Rejection reason"
                    maxLength={1000}
                    onChange={(event) => {
                        setReason(event.target.value);
                        setError(undefined);
                    }}
                    placeholder="Explain what must be corrected before the report can continue."
                    value={reason}
                />
                <p className="text-xs text-muted-foreground">{reason.trim().length}/1000 characters</p>
            </div>
        </Modal>
    );
}