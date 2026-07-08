import { AlertCircle, Eye, ListFilter, Pencil, Plus, Trash2, UserRound } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';
import { useNavigate } from 'react-router-dom';

import { ConfirmDeleteDialog } from '@/components/business/common/ConfirmDeleteDialog';
import { DataToolbar } from '@/components/business/common/DataToolbar';
import { FilterBar } from '@/components/business/common/FilterBar';
import { NoPermission } from '@/components/business/common/NoPermission';
import { SearchBar } from '@/components/business/common/SearchBar';
import { EmployeeAvatar, EmployeeCard } from '@/components/business/employees';
import { PageContainer } from '@/components/layout/PageContainer';
import { Alert, Button, Card, EmptyState, Pagination, Skeleton, Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui';
import { useToast } from '@/providers/ToastProvider';
import type { Employee, EmployeePayload, RoleName } from '@/types';
import { useAuthStore } from '@/stores/auth.store';

import { DepartmentBadge, RoleBadge } from '../components/EmployeeBadges';
import { EmployeeFormDialog } from '../components/EmployeeFormDialog';
import { useCreateEmployeeMutation, useDeleteEmployeeMutation, useEmployeesQuery, useUpdateEmployeeMutation } from '../hooks/useEmployees';
import { employeeSortOptions, getEmployeeCapabilities, getEmployeeName, getEmployeeStatus, getPrimaryRole, roleOptions, statusOptions } from '../utils/employee-utils';

const getErrorMessage = (error: unknown): string => (error instanceof Error ? error.message : 'Employees could not be loaded.');

function EmployeesListSkeleton() {
    return (
        <PageContainer description="Loading employees from the Employees API." eyebrow="Employees" title="Employees">
            <Skeleton className="h-24" />
            <Skeleton className="h-96" />
        </PageContainer>
    );
}

function EmployeeActions({ capabilities, employee, onDelete, onEdit, onOpen, onProfile }: { capabilities: ReturnType<typeof getEmployeeCapabilities>; employee: Employee; onDelete: (employee: Employee) => void; onEdit: (employee: Employee) => void; onOpen: (employee: Employee) => void; onProfile: (employee: Employee) => void }) {
    return (
        <div className="flex flex-wrap items-center justify-end gap-2">
            <Button leftIcon={<Eye aria-hidden="true" className="size-4" />} onClick={() => onOpen(employee)} size="sm" variant="outline">
                Details
            </Button>
            <Button onClick={() => onProfile(employee)} size="sm" variant="ghost">
                Profile
            </Button>
            {capabilities.canUpdate && (
                <Button leftIcon={<Pencil aria-hidden="true" className="size-4" />} onClick={() => onEdit(employee)} size="sm" variant="subtle">
                    Edit
                </Button>
            )}
            {capabilities.canDelete && (
                <Button leftIcon={<Trash2 aria-hidden="true" className="size-4" />} onClick={() => onDelete(employee)} size="sm" variant="danger">
                    Delete
                </Button>
            )}
        </div>
    );
}

export function EmployeesListPage() {
    const navigate = useNavigate();
    const user = useAuthStore((state) => state.user);
    const { notify } = useToast();
    const capabilities = getEmployeeCapabilities(user);
    const [page, setPage] = useState(1);
    const [search, setSearch] = useState('');
    const [department, setDepartment] = useState('');
    const [status, setStatus] = useState<'' | '0' | '1'>('');
    const [role, setRole] = useState<'' | RoleName>('');
    const [sort, setSort] = useState<(typeof employeeSortOptions)[number]['value']>('-created_at');
    const [formOpen, setFormOpen] = useState(false);
    const [editingEmployee, setEditingEmployee] = useState<Employee | null>(null);
    const [deletingEmployee, setDeletingEmployee] = useState<Employee | null>(null);

    const employeesQuery = useEmployeesQuery({
        active: status,
        department,
        page,
        search,
        sort,
    });
    const createEmployee = useCreateEmployeeMutation();
    const updateEmployee = useUpdateEmployeeMutation();
    const deleteEmployee = useDeleteEmployeeMutation();

    useEffect(() => {
        document.title = 'Employees - ReportFlow';
    }, []);

    const employees = employeesQuery.data?.data ?? [];
    const meta = employeesQuery.data?.meta;
    const displayedEmployees = useMemo(
        () => (role ? employees.filter((employee) => employee.roles.includes(role) || employee.role === role) : employees),
        [employees, role],
    );

    const departmentOptions = useMemo(() => {
        const departments = new Set(employees.map((employee) => employee.department).filter((value): value is string => Boolean(value)));

        if (department) {
            departments.add(department);
        }

        return [
            { label: 'All departments', value: '' },
            ...Array.from(departments).sort().map((value) => ({ label: value, value })),
        ];
    }, [department, employees]);

    const resetToFirstPage = () => setPage(1);

    const openCreateDialog = () => {
        setEditingEmployee(null);
        setFormOpen(true);
    };

    const openEditDialog = (employee: Employee) => {
        setEditingEmployee(employee);
        setFormOpen(true);
    };

    const saveEmployee = async (payload: EmployeePayload) => {
        if (editingEmployee) {
            await updateEmployee.mutateAsync({ id: editingEmployee.id, payload });
            notify({ description: 'Employee profile was updated successfully.', intent: 'success', title: 'Employee updated' });
            return;
        }

        await createEmployee.mutateAsync(payload);
        notify({ description: 'Employee was created successfully.', intent: 'success', title: 'Employee created' });
    };

    const confirmDelete = () => {
        if (!deletingEmployee) {
            return;
        }

        deleteEmployee.mutate(deletingEmployee.id, {
            onError: (error) => {
                notify({ description: getErrorMessage(error), intent: 'error', title: 'Delete failed' });
            },
            onSuccess: () => {
                notify({ description: 'Employee was deleted successfully.', intent: 'success', title: 'Employee deleted' });
                setDeletingEmployee(null);
            },
        });
    };

    if (!capabilities.canViewList) {
        return (
            <PageContainer description="The backend Employees API only allows managers and super-admins to list employees." eyebrow="Employees" title="Employees">
                <NoPermission action={{ label: 'Go to dashboard', onClick: () => navigate('/dashboard') }} description="Your role cannot list employees through the backend API." title="Employees list restricted" />
            </PageContainer>
        );
    }

    if (employeesQuery.isLoading) {
        return <EmployeesListSkeleton />;
    }

    if (employeesQuery.isError) {
        return (
            <PageContainer description="The Employees API returned an error." eyebrow="Employees" title="Employees">
                <Alert intent="danger" icon={<AlertCircle aria-hidden="true" className="size-5" />} title="Unable to load employees" description={getErrorMessage(employeesQuery.error)} />
            </PageContainer>
        );
    }

    return (
        <PageContainer
            actions={
                capabilities.canCreate ? (
                    <Button leftIcon={<Plus aria-hidden="true" className="size-4" />} onClick={openCreateDialog}>
                        New employee
                    </Button>
                ) : null
            }
            description="Manage employees through the backend Employees REST API."
            eyebrow="Employees"
            title="Employees"
        >
            <DataToolbar
                actions={
                    <Button
                        leftIcon={<ListFilter aria-hidden="true" className="size-4" />}
                        onClick={() => {
                            setSearch('');
                            setDepartment('');
                            setStatus('');
                            setRole('');
                            setSort('-created_at');
                            setPage(1);
                        }}
                        variant="outline"
                    >
                        Reset
                    </Button>
                }
                filters={
                    <FilterBar
                        filters={[
                            {
                                id: 'department',
                                label: 'Department',
                                onChange: (value) => {
                                    setDepartment(value);
                                    resetToFirstPage();
                                },
                                options: departmentOptions,
                                value: department,
                            },
                            {
                                id: 'status',
                                label: 'Status',
                                onChange: (value) => {
                                    setStatus(value as '' | '0' | '1');
                                    resetToFirstPage();
                                },
                                options: statusOptions,
                                value: status,
                            },
                            {
                                id: 'role',
                                label: 'Role',
                                onChange: (value) => {
                                    setRole(value as '' | RoleName);
                                    resetToFirstPage();
                                },
                                options: roleOptions,
                                value: role,
                            },
                            {
                                id: 'sort',
                                label: 'Sort',
                                onChange: (value) => {
                                    setSort(value as (typeof employeeSortOptions)[number]['value']);
                                    resetToFirstPage();
                                },
                                options: employeeSortOptions,
                                value: sort,
                            },
                        ]}
                    />
                }
                search={
                    <SearchBar
                        id="employee-search"
                        onChange={(value) => {
                            setSearch(value);
                            resetToFirstPage();
                        }}
                        placeholder="Search employees…"
                        value={search}
                    />
                }
            />

            {displayedEmployees.length === 0 ? (
                <EmptyState description="No employees matched the current API filters." icon={<UserRound aria-hidden="true" className="size-10" />} title="No employees found" />
            ) : (
                <>
                    <Card className="hidden p-0 lg:block">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Employee</TableHead>
                                    <TableHead>Department</TableHead>
                                    <TableHead>Role</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Reports</TableHead>
                                    <TableHead className="text-right">Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {displayedEmployees.map((employee) => (
                                    <TableRow key={employee.id}>
                                        <TableCell>
                                            <div className="flex items-center gap-3">
                                                <EmployeeAvatar email={employee.email} name={getEmployeeName(employee)} />
                                                <div className="min-w-0">
                                                    <p className="font-medium text-foreground">{getEmployeeName(employee)}</p>
                                                    <p className="text-xs text-muted-foreground">{employee.email}</p>
                                                </div>
                                            </div>
                                        </TableCell>
                                        <TableCell><DepartmentBadge department={employee.department} /></TableCell>
                                        <TableCell><RoleBadge role={getPrimaryRole(employee)} /></TableCell>
                                        <TableCell>{employee.active ? 'Active' : 'Inactive'}</TableCell>
                                        <TableCell>{employee.reports_count ?? 0}</TableCell>
                                        <TableCell>
                                            <EmployeeActions
                                                capabilities={capabilities}
                                                employee={employee}
                                                onDelete={setDeletingEmployee}
                                                onEdit={openEditDialog}
                                                onOpen={(value) => navigate(`/employees/${value.id}`)}
                                                onProfile={(value) => navigate(`/employees/${value.id}/profile`)}
                                            />
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </Card>

                    <div className="grid gap-4 lg:hidden">
                        {displayedEmployees.map((employee) => (
                            <EmployeeCard
                                actions={
                                    <EmployeeActions
                                        capabilities={capabilities}
                                        employee={employee}
                                        onDelete={setDeletingEmployee}
                                        onEdit={openEditDialog}
                                        onOpen={(value) => navigate(`/employees/${value.id}`)}
                                        onProfile={(value) => navigate(`/employees/${value.id}/profile`)}
                                    />
                                }
                                department={<DepartmentBadge department={employee.department} />}
                                email={employee.email}
                                key={employee.id}
                                name={getEmployeeName(employee)}
                                role={<RoleBadge role={getPrimaryRole(employee)} />}
                                status={getEmployeeStatus(employee)}
                            />
                        ))}
                    </div>
                </>
            )}

            {meta && meta.last_page > 1 && <Pagination className="justify-center" onPageChange={setPage} page={meta.current_page} pageCount={meta.last_page} />}

            <EmployeeFormDialog employee={editingEmployee} isPending={createEmployee.isPending || updateEmployee.isPending} onOpenChange={setFormOpen} onSubmit={saveEmployee} open={formOpen} />

            <ConfirmDeleteDialog
                description="This employee record will be permanently deleted. The backend may retain related reports according to database constraints."
                onConfirm={confirmDelete}
                onOpenChange={(open) => !open && setDeletingEmployee(null)}
                open={Boolean(deletingEmployee)}
                resourceName={deletingEmployee ? getEmployeeName(deletingEmployee) : 'this employee'}
                title="Delete employee"
            />
        </PageContainer>
    );
}