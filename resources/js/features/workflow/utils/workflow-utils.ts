import type { ApprovalTimelineItem } from '@/components/business/workflow/ApprovalTimeline';
import type { WorkflowStep } from '@/components/business/workflow/WorkflowStepper';
import { formatReportDate, getEmployeeName, getReportTitle, hasReportPermission } from '@/features/reports/utils/report-utils';
import type { AuthUser, ReportStatusValue, ReportWorkflowAction, WeeklyReport } from '@/types';

export type WorkflowCapabilities = {
    allowedActions: ReportWorkflowAction[];
    canFinalApprove: boolean;
    canManagerApprove: boolean;
    canReject: boolean;
    canSubmit: boolean;
};

export type WorkflowHistoryEvent = {
    actor: string;
    description: string;
    id: string;
    report: WeeklyReport;
    status: 'approved' | 'current' | 'pending' | 'rejected' | 'skipped';
    timestamp: string;
    title: string;
};

export type WorkflowActionCopy = {
    confirmLabel: string;
    description: string;
    label: string;
    successDescription: string;
    successTitle: string;
    title: string;
};

const workflowStepOrder: ReportStatusValue[] = ['draft', 'submitted', 'manager_approved', 'generated'];

const statusLabels: Record<ReportStatusValue, string> = {
    draft: 'Draft',
    generated: 'Final approved',
    manager_approved: 'Manager approved',
    rejected: 'Rejected',
    submitted: 'Submitted',
};

export const isPendingApprovalStatus = (status: ReportStatusValue) => status === 'submitted' || status === 'manager_approved';

export const getWorkflowCapabilities = (report: WeeklyReport, user: AuthUser | null): WorkflowCapabilities => {
    const canSubmit = report.status.value === 'draft' && hasReportPermission(user, 'reports.submit');
    const canManagerApprove = report.status.value === 'submitted' && hasReportPermission(user, 'reports.approve');
    const canFinalApprove = report.status.value === 'manager_approved' && hasReportPermission(user, 'reports.final-approve');
    const canReject = isPendingApprovalStatus(report.status.value) && hasReportPermission(user, 'reports.reject');
    const allowedActions: ReportWorkflowAction[] = [];

    if (canSubmit) {
        allowedActions.push('submit');
    }

    if (canManagerApprove) {
        allowedActions.push('approve');
    }

    if (canFinalApprove) {
        allowedActions.push('final-approve');
    }

    if (canReject) {
        allowedActions.push('reject');
    }

    return {
        allowedActions,
        canFinalApprove,
        canManagerApprove,
        canReject,
        canSubmit,
    };
};

export const hasAnyWorkflowPermission = (user: AuthUser | null) =>
    hasReportPermission(user, 'reports.submit') ||
    hasReportPermission(user, 'reports.approve') ||
    hasReportPermission(user, 'reports.final-approve') ||
    hasReportPermission(user, 'reports.reject');

export const getWorkflowActionCopy = (action: ReportWorkflowAction, report: WeeklyReport): WorkflowActionCopy => {
    const reportTitle = getReportTitle(report);

    const copies: Record<ReportWorkflowAction, WorkflowActionCopy> = {
        approve: {
            confirmLabel: 'Approve report',
            description: `Manager approve ${reportTitle}. The report will move to final approval.`,
            label: 'Manager approve',
            successDescription: 'The report moved to final approval.',
            successTitle: 'Report approved',
            title: 'Confirm manager approval',
        },
        'final-approve': {
            confirmLabel: 'Final approve',
            description: `Final approve ${reportTitle}. The backend will generate the PowerPoint export when available.`,
            label: 'Final approve',
            successDescription: 'The report was finally approved and generation was triggered.',
            successTitle: 'Report finally approved',
            title: 'Confirm final approval',
        },
        reject: {
            confirmLabel: 'Reject report',
            description: `Reject ${reportTitle}. A rejection reason is required by the backend workflow.`,
            label: 'Reject',
            successDescription: 'The report was rejected and returned to the author.',
            successTitle: 'Report rejected',
            title: 'Reject report',
        },
        submit: {
            confirmLabel: 'Submit report',
            description: `Submit ${reportTitle} for manager approval.`,
            label: 'Submit',
            successDescription: 'The report entered the approval workflow.',
            successTitle: 'Report submitted',
            title: 'Confirm submission',
        },
    };

    return copies[action];
};

const getStepStatus = (report: WeeklyReport, step: ReportStatusValue): WorkflowStep['status'] => {
    if (step === 'rejected') {
        return report.status.value === 'rejected' ? 'current' : 'pending';
    }

    if (report.status.value === 'rejected') {
        if (step === 'generated') {
            return 'skipped';
        }

        if (step === 'manager_approved') {
            return report.validated_at ? 'approved' : 'skipped';
        }

        return step === 'submitted' && report.submitted_at ? 'approved' : 'approved';
    }

    const currentIndex = workflowStepOrder.indexOf(report.status.value);
    const stepIndex = workflowStepOrder.indexOf(step);

    if (stepIndex < currentIndex) {
        return 'approved';
    }

    if (stepIndex === currentIndex) {
        return 'current';
    }

    return 'pending';
};

export const getWorkflowCurrentStepId = (report: WeeklyReport) => (report.status.value === 'rejected' ? 'rejected' : report.status.value);

export const buildWorkflowSteps = (report: WeeklyReport): WorkflowStep[] => [
    {
        description: `Created ${formatReportDate(report.created_at)}`,
        id: 'draft',
        label: statusLabels.draft,
        status: getStepStatus(report, 'draft'),
    },
    {
        description: report.submitted_at ? `Submitted ${formatReportDate(report.submitted_at)}` : 'Waiting for submission',
        id: 'submitted',
        label: statusLabels.submitted,
        status: getStepStatus(report, 'submitted'),
    },
    {
        description: report.validated_at && report.status.value !== 'generated' ? `By ${report.validator ?? 'Manager'} · ${formatReportDate(report.validated_at)}` : 'Waiting for manager approval',
        id: 'manager_approved',
        label: statusLabels.manager_approved,
        status: getStepStatus(report, 'manager_approved'),
    },
    {
        description: report.generated_at ? `Generated ${formatReportDate(report.generated_at)}` : 'Waiting for final approval',
        id: 'generated',
        label: statusLabels.generated,
        status: getStepStatus(report, 'generated'),
    },
    {
        description: report.rejected_at ? `By ${report.rejector ?? 'Reviewer'} · ${formatReportDate(report.rejected_at)}` : 'Alternative terminal state',
        id: 'rejected',
        label: statusLabels.rejected,
        status: getStepStatus(report, 'rejected'),
    },
];

export const buildApprovalTimeline = (report: WeeklyReport): ApprovalTimelineItem[] => {
    const items: ApprovalTimelineItem[] = [
        {
            actor: getEmployeeName(report),
            description: 'The report was created as a draft.',
            id: `${report.id}-created`,
            status: 'approved',
            timestamp: formatReportDate(report.created_at),
            title: 'Draft created',
        },
    ];

    if (report.submitted_at) {
        items.push({
            actor: getEmployeeName(report),
            description: 'The report was submitted to the workflow.',
            id: `${report.id}-submitted`,
            status: report.status.value === 'submitted' ? 'current' : 'approved',
            timestamp: formatReportDate(report.submitted_at),
            title: 'Submitted',
        });
    }

    if (report.validated_at) {
        items.push({
            actor: report.validator ?? 'Approver',
            description: report.status.value === 'generated' ? 'The final approval was completed.' : 'The manager approval was completed.',
            id: `${report.id}-validated`,
            status: report.status.value === 'manager_approved' ? 'current' : 'approved',
            timestamp: formatReportDate(report.validated_at),
            title: report.status.value === 'generated' ? 'Final approved' : 'Manager approved',
        });
    }

    if (report.generated_at) {
        items.push({
            actor: report.validator ?? 'ReportFlow',
            description: 'The backend generated the PowerPoint output.',
            id: `${report.id}-generated`,
            status: 'approved',
            timestamp: formatReportDate(report.generated_at),
            title: 'PowerPoint generated',
        });
    }

    if (report.rejected_at) {
        items.push({
            actor: report.rejector ?? 'Reviewer',
            description: report.rejection_reason ?? 'The report was rejected.',
            id: `${report.id}-rejected`,
            status: 'rejected',
            timestamp: formatReportDate(report.rejected_at),
            title: 'Rejected',
        });
    }

    if (items.length === 1 && report.status.value === 'draft') {
        items.push({
            description: 'The report has not entered approval yet.',
            id: `${report.id}-waiting`,
            status: 'current',
            title: 'Awaiting submission',
        });
    }

    return items;
};

export const buildWorkflowHistory = (reports: readonly WeeklyReport[]): WorkflowHistoryEvent[] => {
    const events = reports.flatMap((report) => {
        const reportEvents: WorkflowHistoryEvent[] = [
            {
                actor: getEmployeeName(report),
                description: getReportTitle(report),
                id: `${report.id}-created`,
                report,
                status: 'approved',
                timestamp: report.created_at,
                title: 'Draft created',
            },
        ];

        if (report.submitted_at) {
            reportEvents.push({
                actor: getEmployeeName(report),
                description: getReportTitle(report),
                id: `${report.id}-submitted`,
                report,
                status: report.status.value === 'submitted' ? 'current' : 'approved',
                timestamp: report.submitted_at,
                title: 'Submitted',
            });
        }

        if (report.validated_at) {
            reportEvents.push({
                actor: report.validator ?? 'Approver',
                description: getReportTitle(report),
                id: `${report.id}-validated`,
                report,
                status: report.status.value === 'manager_approved' ? 'current' : 'approved',
                timestamp: report.validated_at,
                title: report.status.value === 'generated' ? 'Final approved' : 'Manager approved',
            });
        }

        if (report.generated_at) {
            reportEvents.push({
                actor: report.validator ?? 'ReportFlow',
                description: getReportTitle(report),
                id: `${report.id}-generated`,
                report,
                status: 'approved',
                timestamp: report.generated_at,
                title: 'PowerPoint generated',
            });
        }

        if (report.rejected_at) {
            reportEvents.push({
                actor: report.rejector ?? 'Reviewer',
                description: report.rejection_reason ?? getReportTitle(report),
                id: `${report.id}-rejected`,
                report,
                status: 'rejected',
                timestamp: report.rejected_at,
                title: 'Rejected',
            });
        }

        return reportEvents;
    });

    return events.sort((left, right) => new Date(right.timestamp).getTime() - new Date(left.timestamp).getTime());
};