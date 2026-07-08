export type ReportStatusValue = 'draft' | 'generated' | 'manager_approved' | 'rejected' | 'submitted';

export type ReportStatus = {
    color: 'danger' | 'gray' | 'info' | 'success' | 'warning';
    label: string;
    value: ReportStatusValue;
};

export type WeeklyReport = {
    achievements: string;
    activities: string;
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
    next_actions: string;
    objectives: string;
    pptx_file: string | null;
    rejected_at: string | null;
    rejection_reason: string | null;
    rejector: string | null;
    status: ReportStatus;
    submitted_at: string | null;
    updated_at: string;
    validated_at: string | null;
    validator: string | null;
    week: string;
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