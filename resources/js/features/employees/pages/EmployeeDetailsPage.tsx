import { AlertCircle, CalendarDays, ClipboardList, Pencil, Trash2, UserRound } from 'lucide-react';
import { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

import { ConfirmDeleteDialog } from '@/components/business/common/ConfirmDeleteDialog';
import { NoPermission } from '@/components/business/common/NoPermission';
import { EmployeeAvatar } from '@/components/business/employees';
import { PageContainer } from '@/components/layout/PageContainer';
import { Alert, Button, Card, CardContent, CardDescription, CardHeader, CardTitle, EmptyState, Skeleton } from '@/components/ui';
import { useToast } from '@/providers/ToastProvider';
import { useAuthStore } from '@/stores/auth.store';
import type { EmployeePayload } from '@/types';

import { DepartmentBadge, RoleBadge } from '../components/EmployeeBadges';
import { EmployeeFormDialog } from '../components/EmployeeFormDialog';
import { EmployeeReportsPanel } from '../components/EmployeeReportsPanel';
import { EmployeeStatisticsPanel } from '../components/EmployeeStatisticsPanel';
import { useDeleteEmployeeMutation, useEmployeeQuery, useUpdateEmployeeMutation } from '../hooks/useEmployees';
import { canViewEmployee, formatEmployeeDate, getEmployeeCapabilities, getEmployeeName, getPrimaryRole } from '../utils/employee-utils';

const getErrorMessage = (error: unknown): string => (error instanceof Error ? error.message : 'Employee details could not be loaded.');

function EmployeeDetailsSkeleton() {
    return (
        <PageContainer description="Loading employee details from the Employees API." eyebrow="Employees" title="Employee details">
            <Skeleton className="h-40" />
            <Skeleton className="h-40" />
            <Skeleton className="h-96" />
        </PageContainer>
    );
}

export function EmployeeDetailsPage() {
    const navigate = useNavigate();
    const { id } = useParams();
    const employeeId = Number(id);
    const user = useAuthStore((state) => state.user);
    const { notify } = useToast();
    const capabilities = getEmployeeCapabilities(user);
    const [formOpen, setFormOpen] = useState(false);
    const [deleteOpen, setDeleteOpen] = useState(false);
    const employeeQuery = useEmployeeQuery(Number.isFinite(employeeId) ? employeeId : undefined);
    const updateEmployee = useUpdateEmployeeMutation();
    const deleteEmployee = useDeleteEmployeeMutation();

    useEffect(() => {
        document.title = 'Employee details - ReportFlow';
    }, []);

    if (!Number.isFinite(employeeId) || employeeId <= 0) {
        return (
            <PageContainer description="The requested employee identifier is invalid." eyebrow="Employees" title="Employee not found">
                <EmptyState action={{ label: 'Back to employees', onClick: () => navigate('/employees') }} icon={<UserRound aria-hidden="true" className="size-10" />} title="Invalid employee" description="Open an employee from the employees list." />
            </PageContainer>
        );
    }

    if (!canViewEmployee(user, employeeId)) {
        return (
            <PageContainer description="The backend Employees API restricts this employee record." eyebrow="Employees" title="Employee restricted">
                <NoPermission action={{ label: 'Go to dashboard', onClick: () => navigate('/dashboard') }} description="Your role cannot view this employee through the backend API." title="Employee access restricted" />
            </PageContainer>
        );
    }

    if (employeeQuery.isLoading) {
        return <EmployeeDetailsSkeleton />;
    }

    if (employeeQuery.isError) {
        return (
            <PageContainer description="The Employees API returned an error." eyebrow="Employees" title="Employee details">
                <Alert intent="danger" icon={<AlertCircle aria-hidden="true" className="size-5" />} title="Unable to load employee" description={getErrorMessage(employeeQuery.error)} />
            </PageContainer>
        );
    }

    const detail = employeeQuery.data;
    const employee = detail?.data;

    if (!detail || !employee) {
        return (
            <PageContainer description="No employee was returned by the Employees API." eyebrow="Employees" title="Employee not found">
                <EmptyState action={{ label: 'Back to employees', onClick: () => navigate('/employees') }} icon={<UserRound aria-hidden="true" className="size-10" />} title="Employee not found" description="The employee may have been deleted or is no longer available." />
            </PageContainer>
        );
    }

    const saveEmployee = async (payload: EmployeePayload) => {
        await updateEmployee.mutateAsync({ id: employee.id, payload });
        notify({ description: 'Employee profile was updated successfully.', intent: 'success', title: 'Employee updated' });
    };

    const confirmDelete = () => {
        deleteEmployee.mutate(employee.id, {
            onError: (error) => notify({ description: getErrorMessage(error), intent: 'error', title: 'Delete failed' }),
            onSuccess: () => {
                notify({ description: 'Employee was deleted successfully.', intent: 'success', title: 'Employee deleted' });
                navigate('/employees');
            },
        });
    };

    return (
        <PageContainer
            actions={
                <div className="flex flex-wrap items-center gap-2">
                    <Button onClick={() => navigate(`/employees/${employee.id}/profile`)} variant="outline">Profile</Button>
                    <Button onClick={() => navigate(`/employees/${employee.id}/activity`)} variant="outline">Activity</Button>
                    {capabilities.canUpdate && <Button leftIcon={<Pencil aria-hidden="true" className="size-4" />} onClick={() => setFormOpen(true)} variant="subtle">Edit</Button>}
                    {capabilities.canDelete && <Button leftIcon={<Trash2 aria-hidden="true" className="size-4" />} onClick={() => setDeleteOpen(true)} variant="danger">Delete</Button>}
                </div>
            }
            description={`${employee.email} · ${employee.department ?? 'No department'}`}
            eyebrow="Employees"
            title={getEmployeeName(employee)}
        >
            <Card>
                <CardContent className="flex flex-col gap-6 p-6 md:flex-row md:items-center md:justify-between">
                    <div className="flex items-center gap-4">
                        <EmployeeAvatar email={employee.email} name={getEmployeeName(employee)} size="lg" />
                        <div>
                            <h2 className="text-xl font-semibold text-foreground">{getEmployeeName(employee)}</h2>
                            <p className="text-sm text-muted-foreground">{employee.email}</p>
                            <div className="mt-3 flex flex-wrap gap-2">
                                <DepartmentBadge department={employee.department} />
                                <RoleBadge role={getPrimaryRole(employee)} />
                                <span className="text-sm text-muted-foreground">{employee.active ? 'Active' : 'Inactive'}</span>
                            </div>
                        </div>
                    </div>
                    <dl className="grid gap-3 sm:grid-cols-2 md:min-w-80">
                        <div className="rounded-xl bg-muted/60 p-3">
                            <dt className="flex items-center gap-2 text-xs font-medium uppercase tracking-wide text-muted-foreground"><ClipboardList aria-hidden="true" className="size-4" /> Reports</dt>
                            <dd className="mt-1 text-lg font-semibold text-foreground">{employee.reports_count ?? detail.statistics.total_reports}</dd>
                        </div>
                        <div className="rounded-xl bg-muted/60 p-3">
                            <dt className="flex items-center gap-2 text-xs font-medium uppercase tracking-wide text-muted-foreground"><CalendarDays aria-hidden="true" className="size-4" /> Joined</dt>
                            <dd className="mt-1 text-sm font-medium text-foreground">{formatEmployeeDate(employee.created_at)}</dd>
                        </div>
                    </dl>
                </CardContent>
            </Card>

            <EmployeeStatisticsPanel statistics={detail.statistics} />

            <EmployeeReportsPanel reports={detail.recent_reports} title="Recent employee reports" />

            <Card>
                <CardHeader>
                    <CardTitle>Profile metadata</CardTitle>
                    <CardDescription>User account and synchronization metadata returned by the Employee resource.</CardDescription>
                </CardHeader>
                <CardContent>
                    <dl className="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">User ID</dt><dd className="mt-1 font-medium text-foreground">{employee.user.id ?? 'Not linked'}</dd></div>
                        <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">User email</dt><dd className="mt-1 font-medium text-foreground">{employee.user.email ?? 'Not linked'}</dd></div>
                        <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">Created</dt><dd className="mt-1 font-medium text-foreground">{formatEmployeeDate(employee.created_at)}</dd></div>
                        <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">Updated</dt><dd className="mt-1 font-medium text-foreground">{formatEmployeeDate(employee.updated_at)}</dd></div>
                    </dl>
                </CardContent>
            </Card>

            <EmployeeFormDialog employee={employee} isPending={updateEmployee.isPending} onOpenChange={setFormOpen} onSubmit={saveEmployee} open={formOpen} />
            <ConfirmDeleteDialog onConfirm={confirmDelete} onOpenChange={setDeleteOpen} open={deleteOpen} resourceName={getEmployeeName(employee)} title="Delete employee" />
        </PageContainer>
    );
}