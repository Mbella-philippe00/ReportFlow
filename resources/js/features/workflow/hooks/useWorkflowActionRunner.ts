import { useState } from 'react';

import { useToast } from '@/providers/ToastProvider';
import type { ReportWorkflowAction, WeeklyReport } from '@/types';

import { useWorkflowActionMutation } from './useWorkflow';
import { getWorkflowActionCopy } from '../utils/workflow-utils';

export type PendingWorkflowAction = {
    action: ReportWorkflowAction;
    reportId: number;
} | null;

export type RunWorkflowActionInput = {
    action: ReportWorkflowAction;
    comment?: string;
    onSuccess?: (report: WeeklyReport) => void;
    reason?: string;
    report: WeeklyReport;
};

const getErrorMessage = (error: unknown): string => (error instanceof Error ? error.message : 'The workflow action could not be completed.');

export const useWorkflowActionRunner = () => {
    const { notify } = useToast();
    const workflowAction = useWorkflowActionMutation();
    const [pendingAction, setPendingAction] = useState<PendingWorkflowAction>(null);

    const runWorkflowAction = async ({ action, comment, onSuccess, reason, report }: RunWorkflowActionInput) => {
        const copy = getWorkflowActionCopy(action, report);
        setPendingAction({ action, reportId: report.id });

        try {
            const response = await workflowAction.mutateAsync({ action, comment, id: report.id, reason });

            notify({
                description: copy.successDescription,
                intent: 'success',
                title: copy.successTitle,
            });
            onSuccess?.(response.data);

            return true;
        } catch (error) {
            notify({
                description: getErrorMessage(error),
                intent: 'error',
                title: `${copy.label} failed`,
            });

            return false;
        } finally {
            setPendingAction(null);
        }
    };

    return {
        isPending: workflowAction.isPending,
        pendingAction,
        runWorkflowAction,
    };
};
