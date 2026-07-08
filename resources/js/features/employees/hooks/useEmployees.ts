import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import type { QueryClient } from '@tanstack/react-query';

import {
    createEmployee,
    deleteEmployee,
    employeesQueryKeys,
    getEmployee,
    listEmployeeActivity,
    listEmployeeReports,
    listEmployees,
    updateEmployee,
} from '@/services/employees.service';
import type { ListEmployeesParams } from '@/services/employees.service';
import type { ApiSuccessResponse, Employee, EmployeeDetailResponse, EmployeePayload, PaginatedApiResponse } from '@/types';

const updateEmployeeCaches = (queryClient: QueryClient, employee: Employee) => {
    queryClient.setQueriesData<PaginatedApiResponse<Employee>>({ queryKey: employeesQueryKeys.lists() }, (current) => {
        if (!current) {
            return current;
        }

        return {
            ...current,
            data: current.data.map((item) => (item.id === employee.id ? employee : item)),
        };
    });

    queryClient.setQueryData<EmployeeDetailResponse>(employeesQueryKeys.detail(employee.id), (current) => {
        if (!current) {
            return current;
        }

        return {
            ...current,
            data: employee,
        };
    });
};

export const useEmployeesQuery = (params: ListEmployeesParams = {}) =>
    useQuery({
        queryFn: ({ signal }) => listEmployees({ ...params, signal }),
        queryKey: employeesQueryKeys.list(params),
    });

export const useEmployeeQuery = (id: number | undefined) =>
    useQuery({
        enabled: typeof id === 'number' && Number.isFinite(id),
        queryFn: ({ signal }) => getEmployee(id as number, { signal }),
        queryKey: typeof id === 'number' ? employeesQueryKeys.detail(id) : ['employees', 'detail', 'invalid'],
    });

export const useEmployeeReportsQuery = (id: number | undefined, params: ListEmployeesParams = {}) =>
    useQuery({
        enabled: typeof id === 'number' && Number.isFinite(id),
        queryFn: ({ signal }) => listEmployeeReports(id as number, { ...params, signal }),
        queryKey: typeof id === 'number' ? employeesQueryKeys.reports(id, params) : ['employees', 'reports', 'invalid', params],
    });

export const useEmployeeActivityQuery = (id: number | undefined, params: ListEmployeesParams = {}) =>
    useQuery({
        enabled: typeof id === 'number' && Number.isFinite(id),
        queryFn: ({ signal }) => listEmployeeActivity(id as number, { ...params, signal }),
        queryKey: typeof id === 'number' ? employeesQueryKeys.activity(id, params) : ['employees', 'activity', 'invalid', params],
    });

export const useCreateEmployeeMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (payload: EmployeePayload) => createEmployee(payload),
        onSuccess: (response) => {
            queryClient.setQueryData<ApiSuccessResponse<Employee>>(['employees', 'created', response.data.id], response);
            void queryClient.invalidateQueries({ queryKey: employeesQueryKeys.lists() });
        },
    });
};

export const useUpdateEmployeeMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: ({ id, payload }: { id: number; payload: Partial<EmployeePayload> }) => updateEmployee({ id, payload }),
        onSuccess: (response) => {
            updateEmployeeCaches(queryClient, response.data);
        },
    });
};

export const useDeleteEmployeeMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (id: number) => deleteEmployee(id),
        onMutate: async (id) => {
            await queryClient.cancelQueries({ queryKey: employeesQueryKeys.lists() });

            const previousLists = queryClient.getQueriesData<PaginatedApiResponse<Employee>>({ queryKey: employeesQueryKeys.lists() });

            queryClient.setQueriesData<PaginatedApiResponse<Employee>>({ queryKey: employeesQueryKeys.lists() }, (current) => {
                if (!current) {
                    return current;
                }

                return {
                    ...current,
                    data: current.data.filter((employee) => employee.id !== id),
                    meta: {
                        ...current.meta,
                        total: Math.max(0, current.meta.total - 1),
                    },
                };
            });

            return { previousLists };
        },
        onError: (_error, _id, context) => {
            context?.previousLists.forEach(([queryKey, data]) => {
                queryClient.setQueryData(queryKey, data);
            });
        },
        onSettled: (_data, _error, id) => {
            queryClient.removeQueries({ queryKey: employeesQueryKeys.detail(id) });
            void queryClient.invalidateQueries({ queryKey: employeesQueryKeys.all });
        },
    });
};