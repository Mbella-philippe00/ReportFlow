import { WorkflowStepper } from '@/components/business/workflow/WorkflowStepper';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';
import type { WeeklyReport } from '@/types';

import { buildWorkflowSteps, getWorkflowCurrentStepId } from '../utils/workflow-utils';

export type WorkflowStepperPanelProps = {
    report: WeeklyReport;
};

export function WorkflowStepperPanel({ report }: WorkflowStepperPanelProps) {
    return (
        <Card>
            <CardHeader>
                <CardTitle>Workflow status</CardTitle>
                <CardDescription>Draft to final approval, with rejected as an alternate terminal state.</CardDescription>
            </CardHeader>
            <CardContent>
                <WorkflowStepper currentStepId={getWorkflowCurrentStepId(report)} steps={buildWorkflowSteps(report)} />
            </CardContent>
        </Card>
    );
}