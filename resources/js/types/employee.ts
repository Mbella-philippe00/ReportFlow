import type { RoleName } from './auth';
import type { WeeklyReport } from './report';

export type EmployeeUser = {
    email: string | null;
    id: number | null;
    name: string | null;
    roles?: RoleName[];
};

export type Employee = {
    active: boolean;
    created_at: string;
    department: string | null;
    email: string;
    first_name: string;
    full_name: string;
    id: number;
    last_name: string;
    reports_count?: number;
    role: RoleName | null;
    roles: RoleName[];
    updated_at: string;
    user: EmployeeUser;
};

export type EmployeeStatistics = {
    draft_reports: number;
    generated_reports: number;
    last_report_at: string | null;
    manager_approved_reports: number;
    rejected_reports: number;
    submitted_reports: number;
    total_reports: number;
};

export type EmployeeDetailResponse = {
    data: Employee;
    recent_reports: WeeklyReport[];
    statistics: EmployeeStatistics;
    success: true;
};

export type EmployeePayload = {
    active?: boolean;
    department?: string | null;
    email: string;
    first_name: string;
    last_name: string;
    user_id?: number | null;
};

export type EmployeeActivity = {
    causer: {
        email: string | null;
        id: number;
        name: string | null;
    } | null;
    created_at: string;
    description: string;
    event: string | null;
    id: number;
    properties: Record<string, unknown> | null;
    report_id: number | null;
    updated_at: string;
};