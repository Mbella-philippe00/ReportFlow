import { AlertCircle, Pencil, UserRound } from 'lucide-react';
import { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

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
import { useEmployeeQuery, useEmployeeReportsQuery, useUpdateEmployeeMutation } from '../hooks/useEmployees';
import { canViewEmployee, formatEmployeeDate, getEmployeeCapabilities, getEmployeeName, getPrimaryRole } from '../utils/employee-utils';

const getErrorMessage = (error: unknown): string => (error instanceof Error ? error.message : 'Employee profile could not be loaded.');

function EmployeeProfileSkeleton() {
    return (
        <PageContainer description="Loading employee profile from the Employees API." eyebrow="Employees" title="Employee profile">
            <Skeleton className="h-80" />
            <Skeleton className="h-96" />
        </PageContainer>
    );
}

export function EmployeeProfilePage() {
    const navigate = useNavigate();
    const { id } = useParams();
    const employeeId = Number(id);
    const user = useAuthStore((state) => state.user);
    const { notify } = useToast();
    const capabilities = getEmployeeCapabilities(user);
    const [reportsPage, setReportsPage] = useState(1);
    const [formOpen, setFormOpen] = useState(false);
    const employeeQuery = useEmployeeQuery(Number.isFinite(employeeId) ? employeeId : undefined);
    const reportsQuery = useEmployeeReportsQuery(Number.isFinite(employeeId) ? employeeId : undefined, { page: reportsPage });
    const updateEmployee = useUpdateEmployeeMutation();

    useEffect(() => {
        document.title = 'Employee profile - ReportFlow';
    }, []);

    if (!Number.isFinite(employeeId) || employeeId <= 0) {
        return (
            <PageContainer description="The requested employee identifier is invalid." eyebrow="Employees" title="Employee profile">
                <EmptyState action={{ label: 'Back to employees', onClick: () => navigate('/employees') }} icon={<UserRound aria-hidden="true" className="size-10" />} title="Invalid employee" description="Open an employee from the employees list." />
            </PageContainer>
        );
    }

    if (!canViewEmployee(user, employeeId)) {
        return (
            <PageContainer description="The backend Employees API restricts this employee profile." eyebrow="Employees" title="Employee profile restricted">
                <NoPermission action={{ label: 'Go to dashboard', onClick: () => navigate('/dashboard') }} description="Your role cannot view this profile through the backend API." title="Employee profile restricted" />
            </PageContainer>
        );
    }

    if (employeeQuery.isLoading) {
        return <EmployeeProfileSkeleton />;
    }

    if (employeeQuery.isError) {
        return (
            <PageContainer description="The Employees API returned an error." eyebrow="Employees" title="Employee profile">
                <Alert intent="danger" icon={<AlertCircle aria-hidden="true" className="size-5" />} title="Unable to load profile" description={getErrorMessage(employeeQuery.error)} />
            </PageContainer>
        );
    }

    const detail = employeeQuery.data;
    const employee = detail?.data;

    if (!detail || !employee) {
        return (
            <PageContainer description="No employee was returned by the Employees API." eyebrow="Employees" title="Employee profile">
                <EmptyState action={{ label: 'Back to employees', onClick: () => navigate('/employees') }} icon={<UserRound aria-hidden="true" className="size-10" />} title="Employee not found" description="The employee may have been deleted or is no longer available." />
            </PageContainer>
        );
    }

    const saveEmployee = async (payload: EmployeePayload) => {
        await updateEmployee.mutateAsync({ id: employee.id, payload });
        notify({ description: 'Employee profile was updated successfully.', intent: 'success', title: 'Employee updated' });
    };

    const reports = reportsQuery.data?.data ?? [];
    const reportMeta = reportsQuery.data?.meta;

    return (
        <PageContainer
            actions={
                <div className="flex flex-wrap items-center gap-2">
                    <Button onClick={() => navigate(`/employees/${employee.id}`)} variant="outline">Details</Button>
                    <Button onClick={() => navigate(`/employees/${employee.id}/activity`)} variant="outline">Activity</Button>
                    {capabilities.canUpdate && <Button leftIcon={<Pencil aria-hidden="true" className="size-4" />} onClick={() => setFormOpen(true)} variant="subtle">Edit profile</Button>}
                </div>
            }
            description="Profile, role, department, statistics, and paginated reports from the Employees API."
            eyebrow="Employees"
            title={`${getEmployeeName(employee)} profile`}
        >
            <Card>
                <CardContent className="grid gap-6 p-6 lg:grid-cols-[20rem_minmax(0,1fr)]">
                    <div className="flex flex-col items-center rounded-2xl border bg-background p-6 text-center">
                        <EmployeeAvatar email={employee.email} name={getEmployeeName(employee)} size="lg" />
                        <h2 className="mt-4 text-xl font-semibold text-foreground">{getEmployeeName(employee)}</h2>
                        <p className="mt-1 text-sm text-muted-foreground">{employee.email}</p>
                        <div className="mt-4 flex flex-wrap justify-center gap-2">
                            <DepartmentBadge department={employee.department} />
                            <RoleBadge role={getPrimaryRole(employee)} />
                        </div>
                    </div>
                    <div className="grid content-start gap-4">
                        <CardHeader className="p-0">
                            <CardTitle>Employee profile</CardTitle>
                            <CardDescription>Read-only profile metadata returned by the backend Employee resource.</CardDescription>
                        </CardHeader>
                        <dl className="grid gap-3 sm:grid-cols-2">
                            <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">First name</dt><dd className="mt-1 font-medium text-foreground">{employee.first_name}</dd></div>
                            <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">Last name</dt><dd className="mt-1 font-medium text-foreground">{employee.last_name}</dd></div>
                            <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">Status</dt><dd className="mt-1 font-medium text-foreground">{employee.active ? 'Active' : 'Inactive'}</dd></div>
                            <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">Reports count</dt><dd className="mt-1 font-medium text-foreground">{employee.reports_count ?? detail.statistics.total_reports}</dd></div>
                            <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">Created</dt><dd className="mt-1 font-medium text-foreground">{formatEmployeeDate(employee.created_at)}</dd></div>
                            <div className="rounded-xl bg-muted/60 p-3"><dt className="text-xs text-muted-foreground">Updated</dt><dd className="mt-1 font-medium text-foreground">{formatEmployeeDate(employee.updated_at)}</dd></div>
                        </dl>
                    </div>
                </CardContent>
            </Card>

            <EmployeeStatisticsPanel statistics={detail.statistics} />

            {reportsQuery.isError && <Alert intent="danger" title="Unable to load employee reports" description={getErrorMessage(reportsQuery.error)} />}
            <EmployeeReportsPanel
                isLoading={reportsQuery.isLoading}
                onPageChange={setReportsPage}
                page={reportMeta?.current_page ?? reportsPage}
                pageCount={reportMeta?.last_page ?? 1}
                reports={reports}
                title="Paginated employee reports"
            />

            <EmployeeFormDialog employee={employee} isPending={updateEmployee.isPending} onOpenChange={setFormOpen} onSubmit={saveEmployee} open={formOpen} />
        </PageContainer>
    );
}