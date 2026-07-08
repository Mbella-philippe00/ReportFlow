import type { FeatureKey } from '@/config/features';
import type { PermissionName, RoleName } from '@/types';

export type NavigationItem = {
    allowedRoles?: readonly RoleName[];
    feature: FeatureKey;
    href: string;
    icon: string;
    label: string;
    requiredPermissions?: readonly PermissionName[];
};

export const navigationItems: readonly NavigationItem[] = [
    {
        feature: 'dashboard',
        href: '/dashboard',
        icon: 'LayoutDashboard',
        label: 'Dashboard',
        requiredPermissions: ['dashboard.view'],
    },
    {
        feature: 'reports',
        href: '/reports',
        icon: 'FileText',
        label: 'Reports',
        requiredPermissions: ['reports.view'],
    },
    {
        allowedRoles: ['manager', 'super-admin'],
        feature: 'workflow',
        href: '/workflow',
        icon: 'GitPullRequest',
        label: 'Workflow',
        requiredPermissions: ['reports.approve'],
    },
    {
        feature: 'notifications',
        href: '/notifications',
        icon: 'Bell',
        label: 'Notifications',
        requiredPermissions: ['notifications.view'],
    },
    {
        allowedRoles: ['manager', 'super-admin'],
        feature: 'employees',
        href: '/employees',
        icon: 'Users',
        label: 'Employees',
        requiredPermissions: ['employees.view'],
    },
    {
        allowedRoles: ['manager', 'super-admin'],
        feature: 'analytics',
        href: '/analytics',
        icon: 'Activity',
        label: 'Analytics',
        requiredPermissions: ['analytics.view'],
    },
    {
        allowedRoles: ['manager', 'super-admin'],
        feature: 'ai',
        href: '/ai',
        icon: 'Sparkles',
        label: 'AI',
        requiredPermissions: ['ai.use'],
    },
    {
        feature: 'settings',
        href: '/settings',
        icon: 'Settings',
        label: 'Settings',
        requiredPermissions: ['settings.manage'],
    },
];

