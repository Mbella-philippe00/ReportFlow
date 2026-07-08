import { http } from '@/lib/http';
import type { ApiMessageResponse, ApiSuccessResponse, Employee, EmployeeActivity, EmployeeDetailResponse, EmployeePayload, PaginatedApiResponse } from '@/types';

export type ListEmployeesParams = {
    active?: '' | '0' | '1' | 'false' | 'true';
    department?: string;
    direction?: 'asc' | 'desc';
    page?: number;
    per_page?: number;
    search?: string;
    sort?: EmployeeSortValue;
};

export type EmployeeSortValue =
    | '-active'
    | '-created_at'
    | '-department'
    | '-email'
    | '-first_name'
    | '-last_name'
    | '-name'
    | '-reports_count'
    | '-updated_at'
    | 'active'
    | 'created_at'
    | 'department'
    | 'email'
    | 'first_name'
    | 'last_name'
    | 'name'
    | 'reports_count'
    | 'updated_at';

export type ListEmployeesOptions = ListEmployeesParams & {
    signal?: AbortSignal;
};

export type EmployeeMutationOptions = {
    signal?: AbortSignal;
};

export type UpdateEmployeeInput = EmployeeMutationOptions & {
    id: number;
    payload: Partial<EmployeePayload>;
};

const buildEmployeesPath = (path = '/employees', params: ListEmployeesParams = {}) => {
    const searchParams = new URLSearchParams();

    Object.entries(params).forEach(([key, value]) => {
        if (value !== undefined && value !== null && value !== '') {
            searchParams.set(key, String(value));
        }
    });

    const queryString = searchParams.toString();

    return queryString ? `${path}?${queryString}` : path;
};

export const employeesQueryKeys = {
    activity: (id: number, params: ListEmployeesParams = {}) => ['employees', 'activity', id, params] as const,
    all: ['employees'] as const,
    detail: (id: number) => ['employees', 'detail', id] as const,
    lists: () => ['employees', 'list'] as const,
    list: (params: ListEmployeesParams = {}) => ['employees', 'list', params] as const,
    reports: (id: number, params: ListEmployeesParams = {}) => ['employees', 'reports', id, params] as const,
};

export const listEmployees = ({ signal, ...params }: ListEmployeesOptions = {}) =>
    http<PaginatedApiResponse<Employee>>(buildEmployeesPath('/employees', params), {
        signal,
    });

export const getEmployee = (id: number, { signal }: EmployeeMutationOptions = {}) =>
    http<EmployeeDetailResponse>(`/employees/${id}`, {
        signal,
    });

export const createEmployee = (payload: EmployeePayload, { signal }: EmployeeMutationOptions = {}) =>
    http<ApiSuccessResponse<Employee>>('/employees', {
        body: payload,
        method: 'POST',
        signal,
    });

export const updateEmployee = ({ id, payload, signal }: UpdateEmployeeInput) =>
    http<ApiSuccessResponse<Employee>>(`/employees/${id}`, {
        body: payload,
        method: 'PUT',
        signal,
    });

export const deleteEmployee = (id: number, { signal }: EmployeeMutationOptions = {}) =>
    http<ApiMessageResponse>(`/employees/${id}`, {
        method: 'DELETE',
        signal,
    });

export const listEmployeeReports = (id: number, { signal, ...params }: ListEmployeesOptions = {}) =>
    http<PaginatedApiResponse<EmployeeDetailResponse['recent_reports'][number]>>(buildEmployeesPath(`/employees/${id}/reports`, params), {
        signal,
    });

export const listEmployeeActivity = (id: number, { signal, ...params }: ListEmployeesOptions = {}) =>
    http<PaginatedApiResponse<EmployeeActivity>>(buildEmployeesPath(`/employees/${id}/activity`, params), {
        signal,
    });