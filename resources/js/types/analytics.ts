import type { ReportStatusValue } from './report';

export type AnalyticsPeriod = 'custom' | 'last_30_days' | 'last_7_days' | 'quarter' | 'today' | 'year';

export type AnalyticsGranularity = 'monthly' | 'weekly' | 'yearly';

export type AnalyticsFilters = {
    department?: string;
    employee?: number | string;
    from?: string;
    granularity?: AnalyticsGranularity;
    period?: AnalyticsPeriod;
    status?: '' | ReportStatusValue;
    to?: string;
};

export type AnalyticsAppliedFilters = {
    department: string | null;
    employee: number | string | null;
    from: string;
    period: AnalyticsPeriod;
    status: ReportStatusValue | null;
    to: string;
};

export type AnalyticsDuration = {
    hours: number;
    human: string;
    minutes: number;
};

export type AnalyticsStatusDistributionItem = {
    color: 'danger' | 'gray' | 'info' | 'success' | 'warning' | string;
    count: number;
    label: string;
    value: ReportStatusValue;
};

export type AnalyticsOverview = {
    approved_reports: number;
    average_approval_time: AnalyticsDuration;
    completion_rate: number;
    generated_reports: number;
    pending_reports: number;
    rejected_reports: number;
    status_distribution: AnalyticsStatusDistributionItem[];
    submitted_reports: number;
    total_reports: number;
    validation_rate: number;
};

export type AnalyticsTrendPoint = {
    approved_reports: number;
    generated_reports: number;
    label: string;
    pending_reports: number;
    period: string;
    rejected_reports: number;
    submitted_reports: number;
    total_reports: number;
};

export type AnalyticsDataset<TData, TMeta extends Record<string, unknown> = Record<string, unknown>> = {
    data: TData;
    meta: TMeta;
    type: string;
};

export type AnalyticsDistributionItem = {
    label: string;
    total: number;
};

export type AnalyticsReportsData = {
    department_distribution: AnalyticsDistributionItem[];
    generated_powerpoint_statistics: {
        generated_reports: number;
        generation_rate: number;
        reports_with_powerpoint: number;
    };
    status_distribution: AnalyticsStatusDistributionItem[];
    weekly_distribution: AnalyticsDistributionItem[];
};

export type AnalyticsEmployeeData = {
    approval_rate: number;
    average_completion_time: AnalyticsDuration;
    employee: {
        active: boolean;
        department: string | null;
        email: string;
        id: number;
        name: string;
    };
    generated_reports: number;
    reports_submitted: number;
    total_reports: number;
};

export type AnalyticsDepartmentData = {
    active_employees: number;
    completion_rate: number;
    department: string;
    generated_reports: number;
    pending_reports: number;
    rejected_reports: number;
    total_reports: number;
    validation_rate: number;
};

export type AnalyticsWorkflowBottleneck = {
    average_wait_time: AnalyticsDuration;
    pending_reports: number;
    stage: string;
    status: ReportStatusValue;
};

export type AnalyticsWorkflowData = {
    approval_bottlenecks: AnalyticsWorkflowBottleneck[];
    average_processing_time: AnalyticsDuration;
    current_distribution: AnalyticsStatusDistributionItem[];
    transition_rates: {
        final_approval_rate: number;
        manager_approval_rate: number;
        rejection_rate: number;
        submission_rate: number;
    };
};

export type AnalyticsActivity = {
    causer: {
        email: string | null;
        id: number;
        name: string | null;
    } | null;
    description: string;
    event: string | null;
    id: number;
    occurred_at: string;
    properties: Record<string, unknown> | null;
    report_id: number | null;
    type: 'activity' | 'approval' | 'rejection' | 'submission' | string;
};

export type AnalyticsExportOptions = {
    available_formats: string[];
    future_formats: string[];
    datasets?: string[];
    message: string;
    supported: boolean;
};

export type AnalyticsResponse<TData> = {
    data: TData;
    filters: AnalyticsAppliedFilters;
    success: true;
};

export type AnalyticsActivityResponse = {
    data: AnalyticsActivity[];
    filters: AnalyticsAppliedFilters;
    meta: {
        total_activity: number;
    };
    success: true;
};


export type ExecutiveAnalyticsAlert = {
    category: string;
    created_at: string;
    id: string;
    message: string;
    severity: 'critical' | 'high' | 'medium' | string;
    title: string;
};

export type ExecutiveHeadlineMetrics = {
    approval_rate: number;
    average_approval_time: AnalyticsDuration;
    completion_rate: number;
    documents_count: number;
    pending_reports: number;
    rejected_reports: number;
    smart_alerts_count: number;
    total_reports: number;
};

export type ExecutiveTrendPoint = {
    approved_reports: number;
    label: string;
    pending_reports: number;
    period: string;
    rejected_reports: number;
    total_reports: number;
};

export type ExecutiveDepartmentComparison = {
    active_employees: number;
    approval_rate: number;
    approved_reports: number;
    completion_rate: number;
    department: string;
    pending_reports: number;
    rank: number;
    rejected_reports: number;
    score: number;
    total_reports: number;
};

export type ExecutiveEmployeeComparison = {
    approval_rate: number;
    approved_reports: number;
    average_completion_time: AnalyticsDuration;
    employee: {
        department: string | null;
        email: string;
        id: number;
        name: string;
    };
    rank: number;
    score: number;
    submission_rate: number;
    submitted_reports: number;
    total_reports: number;
};

export type ExecutiveDashboardData = {
    department_leaders: ExecutiveDepartmentComparison[];
    employee_leaders: ExecutiveEmployeeComparison[];
    headline_metrics: ExecutiveHeadlineMetrics;
    smart_alerts: ExecutiveAnalyticsAlert[];
    trendlines: ExecutiveTrendPoint[];
    workflow_health: {
        bottlenecks: Record<string, AnalyticsDuration>;
        stage_counts: Record<ReportStatusValue, number>;
    };
};

export type ExecutiveKpi = {
    delta: number;
    id: string;
    label: string;
    status: 'attention' | 'on_track' | string;
    target: number;
    unit: string;
    value: number;
};

export type ExecutiveKpiCenterData = {
    categories: Record<string, string[]>;
    kpis: ExecutiveKpi[];
};

export type ExecutiveComparisonsData = {
    departments: ExecutiveDepartmentComparison[];
    employees: ExecutiveEmployeeComparison[];
};

export type ExecutiveReportData = {
    decision_points: ExecutiveAnalyticsAlert[];
    department_focus: ExecutiveDepartmentComparison[];
    employee_focus: ExecutiveEmployeeComparison[];
    generated_at: string;
    recommendations: string[];
    summary: string[];
    title: string;
};
