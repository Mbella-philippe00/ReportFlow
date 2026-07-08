import { AlertCircle, UserRound } from 'lucide-react';
import { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

import { NoPermission } from '@/components/business/common/NoPermission';
import { EmployeeAvatar } from '@/components/business/employees';
import { PageContainer } from '@/components/layout/PageContainer';
import { Alert, Button, Card, CardContent, EmptyState, Skeleton } from '@/components/ui';
import { useAuthStore } from '@/stores/auth.store';

import { DepartmentBadge, RoleBadge } from '../components/EmployeeBadges';
import { EmployeeActivityTimeline } from '../components/EmployeeActivityTimeline';
import { useEmployeeActivityQuery, useEmployeeQuery } from '../hooks/useEmployees';
import { canViewEmployee, getEmployeeName, getPrimaryRole } from '../utils/employee-utils';

const getErrorMessage = (error: unknown): string => (error instanceof Error ? error.message : 'Employee activity could not be loaded.');

function EmployeeActivitySkeleton() {
    return (
        <PageContainer description="Loading employee activity from the Employees API." eyebrow="Employees" title="Employee activity">
            <Skeleton className="h-32" />
            <Skeleton className="h-96" />
        </PageContainer>
    );
}

export function EmployeeActivityPage() {
    const navigate = useNavigate();
    const { id } = useParams();
    const employeeId = Number(id);
    const user = useAuthStore((state) => state.user);
    const [activityPage, setActivityPage] = useState(1);
    const employeeQuery = useEmployeeQuery(Number.isFinite(employeeId) ? employeeId : undefined);
    const activityQuery = useEmployeeActivityQuery(Number.isFinite(employeeId) ? employeeId : undefined, { page: activityPage });

    useEffect(() => {
        document.title = 'Employee activity - ReportFlow';
    }, []);

    if (!Number.isFinite(employeeId) || employeeId <= 0) {
        return (
            <PageContainer description="The requested employee identifier is invalid." eyebrow="Employees" title="Employee activity">
                <EmptyState action={{ label: 'Back to employees', onClick: () => navigate('/employees') }} icon={<UserRound aria-hidden="true" className="size-10" />} title="Invalid employee" description="Open an employee from the employees list." />
            </PageContainer>
        );
    }

    if (!canViewEmployee(user, employeeId)) {
        return (
            <PageContainer description="The backend Employees API restricts this employee activity." eyebrow="Employees" title="Employee activity restricted">
                <NoPermission action={{ label: 'Go to dashboard', onClick: () => navigate('/dashboard') }} description="Your role cannot view this activity through the backend API." title="Employee activity restricted" />
            </PageContainer>
        );
    }

    if (employeeQuery.isLoading) {
        return <EmployeeActivitySkeleton />;
    }

    if (employeeQuery.isError) {
        return (
            <PageContainer description="The Employees API returned an error." eyebrow="Employees" title="Employee activity">
                <Alert intent="danger" icon={<AlertCircle aria-hidden="true" className="size-5" />} title="Unable to load employee" description={getErrorMessage(employeeQuery.error)} />
            </PageContainer>
        );
    }

    const employee = employeeQuery.data?.data;
    const activities = activityQuery.data?.data ?? [];
    const activityMeta = activityQuery.data?.meta;

    if (!employee) {
        return (
            <PageContainer description="No employee was returned by the Employees API." eyebrow="Employees" title="Employee activity">
                <EmptyState action={{ label: 'Back to employees', onClick: () => navigate('/employees') }} icon={<UserRound aria-hidden="true" className="size-10" />} title="Employee not found" description="The employee may have been deleted or is no longer available." />
            </PageContainer>
        );
    }

    return (
        <PageContainer
            actions={
                <div className="flex flex-wrap items-center gap-2">
                    <Button onClick={() => navigate(`/employees/${employee.id}`)} variant="outline">Details</Button>
                    <Button onClick={() => navigate(`/employees/${employee.id}/profile`)} variant="outline">Profile</Button>
                </div>
            }
            description="Workflow activity for this employee's reports from the Employee Activity API endpoint."
            eyebrow="Employees"
            title={`${getEmployeeName(employee)} activity`}
        >
            <Card>
                <CardContent className="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">
                    <div className="flex items-center gap-4">
                        <EmployeeAvatar email={employee.email} name={getEmployeeName(employee)} />
                        <div>
                            <h2 className="text-lg font-semibold text-foreground">{getEmployeeName(employee)}</h2>
                            <p className="text-sm text-muted-foreground">{employee.email}</p>
                        </div>
                    </div>
                    <div className="flex flex-wrap gap-2">
                        <DepartmentBadge department={employee.department} />
                        <RoleBadge role={getPrimaryRole(employee)} />
                    </div>
                </CardContent>
            </Card>

            {activityQuery.isError && <Alert intent="danger" title="Unable to load employee activity" description={getErrorMessage(activityQuery.error)} />}
            <EmployeeActivityTimeline
                activities={activities}
                isLoading={activityQuery.isLoading}
                onPageChange={setActivityPage}
                page={activityMeta?.current_page ?? activityPage}
                pageCount={activityMeta?.last_page ?? 1}
            />
        </PageContainer>
    );
}