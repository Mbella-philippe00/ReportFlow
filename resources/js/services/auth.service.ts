import { resolvePermissionsForRoles } from '@/config/permissions';
import { http } from '@/lib/http';
import type { AuthUser, PermissionName, RoleName } from '@/types';

export type LoginCredentials = {
    email: string;
    password: string;
};

type BackendAuthUser = {
    email: string;
    employee?: AuthUser['employee'] | null;
    id: number;
    name: string;
    permissions?: string[];
    roles?: string[];
};

type LoginResponse = {
    message: string;
    success: true;
    token: string;
    token_type: 'Bearer' | string;
    user: BackendAuthUser;
};

type CurrentUserResponse = {
    success: true;
    user: BackendAuthUser;
};

const validRoles: readonly RoleName[] = ['employee', 'manager', 'super-admin'];

const normalizeRoles = (roles: readonly string[] | undefined): RoleName[] =>
    (roles ?? []).filter((role): role is RoleName => validRoles.includes(role as RoleName));

const knownPermissions: readonly PermissionName[] = [
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

const normalizePermissions = (roles: readonly RoleName[], permissions: readonly string[] | undefined): PermissionName[] => {
    const explicitPermissions = permissions?.filter((permission): permission is PermissionName =>
        knownPermissions.includes(permission as PermissionName),
    );

    if (explicitPermissions && explicitPermissions.length > 0) {
        return explicitPermissions;
    }

    return resolvePermissionsForRoles(roles);
};

export const normalizeAuthUser = (user: BackendAuthUser): AuthUser => {
    const roles = normalizeRoles(user.roles);

    return {
        email: user.email,
        employee: user.employee ?? null,
        id: user.id,
        name: user.name,
        permissions: normalizePermissions(roles, user.permissions),
        roles,
    };
};

export const login = async (credentials: LoginCredentials, signal?: AbortSignal) => {
    const response = await http<LoginResponse>('/login', {
        authenticated: false,
        body: credentials,
        method: 'POST',
        signal,
    });

    return {
        token: response.token,
        user: normalizeAuthUser(response.user),
    };
};

export const getCurrentUser = async (signal?: AbortSignal) => {
    const response = await http<CurrentUserResponse>('/me', {
        signal,
    });

    return normalizeAuthUser(response.user);
};

export const logout = (signal?: AbortSignal) =>
    http<{ message: string; success: true }>('/logout', {
        method: 'POST',
        signal,
    });
