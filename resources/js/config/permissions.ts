import type { PermissionName, RoleName } from '@/types';

export const roles: readonly RoleName[] = ['super-admin', 'manager', 'employee'];

export const permissions: readonly PermissionName[] = [
    'ai.use',
    'analytics.view',
    'dashboard.view',
    'employees.view',
    'notifications.view',
    'profile.view',
    'reports.create',
    'reports.update',
    'reports.view',
    'reports.submit',
    'reports.approve',
    'reports.final-approve',
    'reports.reject',
    'settings.manage',
];

export const roleLabels: Record<RoleName, string> = {
    employee: 'Employee',
    manager: 'Manager',
    'super-admin': 'Super Admin',
};

