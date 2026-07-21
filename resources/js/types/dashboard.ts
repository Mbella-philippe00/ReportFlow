import type { WeeklyReport } from '@/types/report';

export type DashboardStatistics = {
    approved_reports: number;
    draft_reports?: number;
    final_approval_queue?: number;
    generated_reports: number;
    manager_queue?: number;
    pending_reports: number;
    rejected_reports: number;
    submitted_reports?: number;
    total_reports: number;
    under_review_reports?: number;
    validation_rate: number;
};

export type DashboardCharts = {
    reports_by_status: Record<string, number>;
};

export type DashboardData = {
    charts: DashboardCharts;
    pending_reports: WeeklyReport[];
    recent_reports: WeeklyReport[];
    statistics: DashboardStatistics;
};
