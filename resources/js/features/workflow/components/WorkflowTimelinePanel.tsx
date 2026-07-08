import { ApprovalTimeline } from '@/components/business/workflow/ApprovalTimeline';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';
import type { WeeklyReport } from '@/types';

import { buildApprovalTimeline } from '../utils/workflow-utils';

export type WorkflowTimelinePanelProps = {
    report: WeeklyReport;
};

export function WorkflowTimelinePanel({ report }: WorkflowTimelinePanelProps) {
    return (
        <Card>
            <CardHeader>
                <CardTitle>Approval timeline</CardTitle>
                <CardDescription>Workflow timestamps and responsible users returned by the backend.</CardDescription>
            </CardHeader>
            <CardContent>
                <ApprovalTimeline items={buildApprovalTimeline(report)} />
            </CardContent>
        </Card>
    );
}