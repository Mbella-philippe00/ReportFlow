export type ReportStatusValue = 'approved' | 'draft' | 'rejected' | 'submitted' | 'under_review';

export type ReportStatus = {
    color: 'danger' | 'gray' | 'info' | 'success' | 'warning';
    label: string;
    value: ReportStatusValue;
};

export type WorkflowTimelineEvent = {
    actor: string | null;
    comment: string | null;
    key: ReportStatusValue | string;
    label: string;
    occurred_at: string | null;
    status: 'completed' | 'current' | 'pending' | 'rejected' | string;
};

export type WeeklyReport = {
    achievements: string;
    activities: string;
    approved_at: string | null;
    approver: string | null;
    available_actions: ReportWorkflowAction[];
    created_at: string;
    department: string;
    difficulties: string | null;
    employee: {
        email: string | null;
        id: number | null;
        name: string | null;
    };
    executive_summary: string | null;
    generated_at: string | null;
    id: number;
    is_read_only: boolean;
    manager_comment: string | null;
    next_actions: string;
    objectives: string;
    pptx_file: string | null;
    rejected_at: string | null;
    rejection_reason: string | null;
    rejector: string | null;
    status: ReportStatus;
    submitted_at: string | null;
    under_review_at: string | null;
    updated_at: string;
    validated_at: string | null;
    validator: string | null;
    week: string;
    workflow?: {
        next_statuses: ReportStatusValue[];
        timeline: WorkflowTimelineEvent[];
    };
};

export type ReportPayload = {
    achievements: string;
    activities: string;
    department: string;
    difficulties?: string | null;
    employee_id: number;
    next_actions: string;
    objectives: string;
    week: string;
};

export type ReportWorkflowAction = 'approve' | 'final-approve' | 'reject' | 'submit';
