import type { ApprovalTimelineItem } from '@/components/business/workflow/ApprovalTimeline';
import type { WorkflowStep } from '@/components/business/workflow/WorkflowStepper';
import { formatReportDate, getEmployeeName, getReportTitle, hasReportPermission } from '@/features/reports/utils/report-utils';
import type { AuthUser, ReportStatusValue, ReportWorkflowAction, WeeklyReport, WorkflowTimelineEvent } from '@/types';

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

const workflowStepOrder: ReportStatusValue[] = ['draft', 'submitted', 'under_review', 'approved'];

const statusLabels: Record<ReportStatusValue, string> = {
    approved: 'Approved',
    draft: 'Draft',
    rejected: 'Rejected',
    submitted: 'Submitted',
    under_review: 'Under Review',
};

const timelineStatusMap: Record<string, ApprovalTimelineItem['status']> = {
    completed: 'approved',
    current: 'current',
    pending: 'pending',
    rejected: 'rejected',
};

const timelineText = (value: ApprovalTimelineItem['title'], fallback = ''): string => {
    if (['bigint', 'boolean', 'number', 'string'].includes(typeof value)) {
        return String(value);
    }

    return fallback;
};

export const isPendingApprovalStatus = (status: ReportStatusValue) => status === 'submitted' || status === 'under_review';

const backendActions = (report: WeeklyReport): ReportWorkflowAction[] => report.available_actions ?? [];

export const getWorkflowCapabilities = (report: WeeklyReport, user: AuthUser | null): WorkflowCapabilities => {
    const actions = backendActions(report);
    const canSubmit = actions.includes('submit') || ((report.status.value === 'draft' || report.status.value === 'rejected') && hasReportPermission(user, 'reports.submit'));
    const canManagerApprove = actions.includes('approve') || (report.status.value === 'submitted' && hasReportPermission(user, 'reports.approve'));
    const canFinalApprove = actions.includes('final-approve') || (report.status.value === 'under_review' && hasReportPermission(user, 'reports.final-approve'));
    const canReject = actions.includes('reject') || (isPendingApprovalStatus(report.status.value) && hasReportPermission(user, 'reports.reject'));
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
            confirmLabel: 'Move under review',
            description: `Move ${reportTitle} under review and send it to final approval. Add a manager comment for the timeline.`,
            label: 'Start review',
            successDescription: 'The report moved under review and the final approvers were notified.',
            successTitle: 'Report under review',
            title: 'Confirm manager review',
        },
        'final-approve': {
            confirmLabel: 'Approve report',
            description: `Approve ${reportTitle}. The backend will generate the PowerPoint export when available.`,
            label: 'Approve',
            successDescription: 'The report was approved and locked read-only.',
            successTitle: 'Report approved',
            title: 'Confirm approval',
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
            description: `Submit ${reportTitle} for manager review.`,
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
        if (step === 'approved') {
            return 'skipped';
        }

        if (step === 'under_review') {
            return report.under_review_at || report.validated_at ? 'approved' : 'skipped';
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
        description: report.under_review_at || report.validated_at ? `By ${report.validator ?? 'Manager'} · ${formatReportDate(report.under_review_at ?? report.validated_at)}` : 'Waiting for manager review',
        id: 'under_review',
        label: statusLabels.under_review,
        status: getStepStatus(report, 'under_review'),
    },
    {
        description: report.approved_at || report.generated_at ? `Approved ${formatReportDate(report.approved_at ?? report.generated_at)}` : 'Waiting for final approval',
        id: 'approved',
        label: statusLabels.approved,
        status: getStepStatus(report, 'approved'),
    },
    {
        description: report.rejected_at ? `By ${report.rejector ?? 'Reviewer'} · ${formatReportDate(report.rejected_at)}` : 'Alternative terminal state',
        id: 'rejected',
        label: statusLabels.rejected,
        status: getStepStatus(report, 'rejected'),
    },
];

const fromBackendTimeline = (report: WeeklyReport, event: WorkflowTimelineEvent): ApprovalTimelineItem => ({
    actor: event.actor ?? (event.key === 'draft' || event.key === 'submitted' ? getEmployeeName(report) : 'ReportFlow'),
    description: event.comment ?? getReportTitle(report),
    id: `${report.id}-${event.key}`,
    status: timelineStatusMap[event.status] ?? (event.key === 'rejected' ? 'rejected' : 'approved'),
    timestamp: formatReportDate(event.occurred_at),
    title: event.label,
});

export const buildApprovalTimeline = (report: WeeklyReport): ApprovalTimelineItem[] => {
    if (report.workflow?.timeline?.length) {
        return report.workflow.timeline.map((event) => fromBackendTimeline(report, event));
    }

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

    if (report.under_review_at || report.validated_at) {
        items.push({
            actor: report.validator ?? 'Manager',
            description: report.manager_comment ?? 'The manager review was completed.',
            id: `${report.id}-under-review`,
            status: report.status.value === 'under_review' ? 'current' : 'approved',
            timestamp: formatReportDate(report.under_review_at ?? report.validated_at),
            title: 'Under Review',
        });
    }

    if (report.approved_at || report.generated_at) {
        items.push({
            actor: report.approver ?? 'Final approver',
            description: 'The report was approved and locked read-only.',
            id: `${report.id}-approved`,
            status: 'approved',
            timestamp: formatReportDate(report.approved_at ?? report.generated_at),
            title: 'Approved',
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
    const events = reports.flatMap((report) =>
        buildApprovalTimeline(report)
            .filter((item) => item.timestamp && item.timestamp !== 'Not available')
            .map((item): WorkflowHistoryEvent => ({
                actor: timelineText(item.actor, 'ReportFlow'),
                description: timelineText(item.description),
                id: item.id,
                report,
                status: item.status,
                timestamp: timelineText(item.timestamp, report.updated_at),
                title: timelineText(item.title, 'Workflow update'),
            })),
    );

    return events.sort((left, right) => new Date(right.timestamp).getTime() - new Date(left.timestamp).getTime());
};
