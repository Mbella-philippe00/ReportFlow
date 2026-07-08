import type { AuthUser, Employee, EmployeePayload, RoleName } from '@/types';
import type { EmployeeFormValues } from '../schemas/employee.schema';

export type EmployeeCapabilities = {
    canCreate: boolean;
    canDelete: boolean;
    canUpdate: boolean;
    canViewList: boolean;
};

export const roleOptions = [
    { label: 'All roles', value: '' },
    { label: 'Employee', value: 'employee' },
    { label: 'Manager', value: 'manager' },
    { label: 'Super admin', value: 'super-admin' },
] as const;

export const statusOptions = [
    { label: 'All statuses', value: '' },
    { label: 'Active', value: '1' },
    { label: 'Inactive', value: '0' },
] as const;

export const employeeSortOptions = [
    { label: 'Newest created', value: '-created_at' },
    { label: 'Name A-Z', value: 'name' },
    { label: 'Name Z-A', value: '-name' },
    { label: 'Department A-Z', value: 'department' },
    { label: 'Email A-Z', value: 'email' },
    { label: 'Most reports', value: '-reports_count' },
    { label: 'Active first', value: '-active' },
] as const;

export const hasAnyRole = (user: AuthUser | null, roles: readonly RoleName[]) => Boolean(user && roles.some((role) => user.roles.includes(role)));

export const getEmployeeCapabilities = (user: AuthUser | null): EmployeeCapabilities => {
    const isManager = hasAnyRole(user, ['manager', 'super-admin']);
    const isSuperAdmin = hasAnyRole(user, ['super-admin']);

    return {
        canCreate: isManager,
        canDelete: isSuperAdmin,
        canUpdate: isManager,
        canViewList: isManager,
    };
};

export const canViewEmployee = (user: AuthUser | null, employeeId: number) =>
    hasAnyRole(user, ['manager', 'super-admin']) || user?.employee?.id === employeeId;

export const getEmployeeName = (employee: Employee) => employee.full_name || `${employee.first_name} ${employee.last_name}`.trim() || employee.email;

export const getEmployeeStatus = (employee: Employee): 'active' | 'inactive' => (employee.active ? 'active' : 'inactive');

export const getPrimaryRole = (employee: Employee): RoleName | null => employee.role ?? employee.roles[0] ?? null;

export const formatEmployeeDate = (value: string | null | undefined) => {
    if (!value) {
        return 'Not available';
    }

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return 'Not available';
    }

    return new Intl.DateTimeFormat('en-US', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    }).format(date);
};

export const getEmployeeFormDefaults = (employee?: Employee | null): EmployeeFormValues => ({
    active: employee?.active ?? true,
    department: employee?.department ?? '',
    email: employee?.email ?? '',
    first_name: employee?.first_name ?? '',
    last_name: employee?.last_name ?? '',
    user_id: employee?.user.id ? String(employee.user.id) : '',
});

export const createEmployeePayload = (values: EmployeeFormValues): EmployeePayload => ({
    active: values.active,
    department: values.department?.trim() || null,
    email: values.email.trim(),
    first_name: values.first_name.trim(),
    last_name: values.last_name.trim(),
    user_id: values.user_id ? Number(values.user_id) : null,
});