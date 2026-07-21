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

export const rolePermissions: Record<RoleName, readonly PermissionName[]> = {
    employee: [
        'dashboard.view',
        'notifications.view',
        'profile.view',
        'reports.create',
        'reports.submit',
        'reports.update',
        'reports.view',
    ],
    manager: [
        'ai.use',
        'analytics.view',
        'dashboard.view',
        'employees.view',
        'notifications.view',
        'profile.view',
        'reports.approve',
        'reports.create',
        'reports.reject',
        'reports.submit',
        'reports.update',
        'reports.view',
    ],
    'super-admin': permissions,
};

export const resolvePermissionsForRoles = (roleNames: readonly RoleName[]): PermissionName[] => {
    const resolved = new Set<PermissionName>();

    roleNames.forEach((role) => {
        rolePermissions[role].forEach((permission) => resolved.add(permission));
    });

    return Array.from(resolved);
};
