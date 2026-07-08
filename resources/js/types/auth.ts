export type RoleName = 'employee' | 'manager' | 'super-admin';

export type PermissionName =
    | 'ai.use'
    | 'analytics.view'
    | 'dashboard.view'
    | 'employees.view'
    | 'notifications.view'
    | 'profile.view'
    | 'reports.create'
    | 'reports.update'
    | 'reports.view'
    | 'reports.submit'
    | 'reports.approve'
    | 'reports.final-approve'
    | 'reports.reject'
    | 'settings.manage';

export type EmployeeSummary = {
    active?: boolean;
    department?: string | null;
    email: string;
    first_name?: string;
    full_name?: string;
    id: number;
    last_name?: string;
};

export type AuthUser = {
    email: string;
    employee?: EmployeeSummary | null;
    id: number;
    name: string;
    permissions?: PermissionName[];
    roles: RoleName[];
};

export type AuthStatus = 'authenticated' | 'checking' | 'guest' | 'idle';

