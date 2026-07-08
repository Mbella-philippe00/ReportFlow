import type { WeeklyReport } from '@/types/report';

export type DashboardStatistics = {
    generated_reports: number;
    pending_reports: number;
    rejected_reports: number;
    total_reports: number;
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
