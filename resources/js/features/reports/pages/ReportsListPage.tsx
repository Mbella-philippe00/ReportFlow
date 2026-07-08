import { AlertCircle, FilePlus2, FileText, RefreshCw } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';
import { useNavigate, useSearchParams } from 'react-router-dom';

import {
    ConfirmDeleteDialog,
    DataToolbar,
    FilterBar,
    ReportCard,
    ReportStatusBadge,
    SearchBar,
    SectionHeader,
} from '@/components/business';
import { PageContainer } from '@/components/layout/PageContainer';
import {
    Alert,
    Button,
    Card,
    CardContent,
    CardHeader,
    EmptyState,
    Pagination,
    Skeleton,
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui';
import { appConfig } from '@/config/app';
import { ReportActionBar } from '@/features/reports/components/ReportActionBar';
import { useCreateReportMutation, useDeleteReportMutation, useReportsQuery, useSubmitReportMutation } from '@/features/reports/hooks/useReports';
import {
    createReportPayload,
    formatReportDate,
    getEmployeeName,
    getReportCapabilities,
    getReportFormDefaults,
    getReportProgress,
    getReportTitle,
    hasReportPermission,
    reportSortOptions,
    reportStatusOptions,
    resolveReportAssetUrl,
} from '@/features/reports/utils/report-utils';
import type { ReportSortValue } from '@/features/reports/utils/report-utils';
import { useToast } from '@/providers/ToastProvider';
import { useAuthStore } from '@/stores/auth.store';
import type { WeeklyReport } from '@/types';

const getErrorMessage = (error: unknown) => (error instanceof Error ? error.message : 'Reports could not be loaded.');

function ReportsTableSkeleton() {
    return (
        <Card>
            <CardHeader>
                <Skeleton className="h-5 w-40" />
            </CardHeader>
            <CardContent className="grid gap-3">
                {Array.from({ length: 6 }, (_, index) => (
                    <Skeleton className="h-12 w-full" key={index} />
                ))}
            </CardContent>
        </Card>
    );
}

const sortReports = (reports: readonly WeeklyReport[], sort: ReportSortValue) => {
    const sortedReports = [...reports];

    sortedReports.sort((left, right) => {
        if (sort === 'updated_asc') {
            return new Date(left.updated_at).getTime() - new Date(right.updated_at).getTime();
        }

        if (sort === 'week_asc') {
            return left.week.localeCompare(right.week);
        }

        if (sort === 'week_desc') {
            return right.week.localeCompare(left.week);
        }

        if (sort === 'department_asc') {
            return left.department.localeCompare(right.department);
        }

        if (sort === 'department_desc') {
            return right.department.localeCompare(left.department);
        }

        return new Date(right.updated_at).getTime() - new Date(left.updated_at).getTime();
    });

    return sortedReports;
};

const filterReports = (reports: readonly WeeklyReport[], search: string, status: string, department: string) => {
    const normalizedSearch = search.trim().toLowerCase();

    return reports.filter((report) => {
        const matchesSearch =
            normalizedSearch.length === 0 ||
            [report.week, report.department, getEmployeeName(report), report.status.label, report.objectives, report.activities, report.achievements]
                .join(' ')
                .toLowerCase()
                .includes(normalizedSearch);
        const matchesStatus = status.length === 0 || report.status.value === status;
        const matchesDepartment = department.length === 0 || report.department === department;

        return matchesSearch && matchesStatus && matchesDepartment;
    });
};

export function ReportsListPage() {
    const navigate = useNavigate();
    const { notify } = useToast();
    const user = useAuthStore((state) => state.user);
    const [searchParams, setSearchParams] = useSearchParams();
    const page = Math.max(1, Number(searchParams.get('page') ?? '1'));
    const [search, setSearch] = useState('');
    const [status, setStatus] = useState('');
    const [department, setDepartment] = useState('');
    const [sort, setSort] = useState<ReportSortValue>('updated_desc');
    const [reportToDelete, setReportToDelete] = useState<WeeklyReport | null>(null);
    const [pendingAction, setPendingAction] = useState<{ action: 'delete' | 'duplicate' | 'submit'; id: number } | null>(null);

    const reportsQuery = useReportsQuery({ page });
    const createReportMutation = useCreateReportMutation();
    const deleteReportMutation = useDeleteReportMutation();
    const submitReportMutation = useSubmitReportMutation();
    const canCreateReports = hasReportPermission(user, 'reports.create');
    const canViewReports = hasReportPermission(user, 'reports.view');
    const reports = reportsQuery.data?.data ?? [];
    const meta = reportsQuery.data?.meta;

    useEffect(() => {
        document.title = `Reports - ${appConfig.name}`;
    }, []);

    const departmentOptions = useMemo(() => {
        const departments = Array.from(new Set(reports.map((report) => report.department))).sort((left, right) => left.localeCompare(right));

        return [
            { label: 'All departments', value: '' },
            ...departments.map((departmentOption) => ({ label: departmentOption, value: departmentOption })),
        ];
    }, [reports]);

    const visibleReports = useMemo(
        () => sortReports(filterReports(reports, search, status, department), sort),
        [department, reports, search, sort, status],
    );

    const setPage = (nextPage: number) => {
        setSearchParams({ page: String(nextPage) });
    };

    const resetFilters = () => {
        setSearch('');
        setStatus('');
        setDepartment('');
        setSort('updated_desc');
    };

    const duplicateReport = async (report: WeeklyReport) => {
        const employeeId = report.employee.id ?? user?.employee?.id ?? null;

        if (!employeeId) {
            notify({
                description: 'The existing Reports API requires an employee ID before a report can be duplicated.',
                intent: 'error',
                title: 'Duplicate unavailable',
            });
            return;
        }

        setPendingAction({ action: 'duplicate', id: report.id });

        try {
            const response = await createReportMutation.mutateAsync(createReportPayload(getReportFormDefaults(report, employeeId)));
            notify({ intent: 'success', title: 'Report duplicated' });
            navigate(`/reports/${response.data.id}/edit`);
        } catch (error) {
            notify({
                description: getErrorMessage(error),
                intent: 'error',
                title: 'Duplicate failed',
            });
        } finally {
            setPendingAction(null);
        }
    };

    const submitReport = async (report: WeeklyReport) => {
        setPendingAction({ action: 'submit', id: report.id });

        try {
            await submitReportMutation.mutateAsync(report.id);
            notify({ intent: 'success', title: 'Report submitted' });
        } catch (error) {
            notify({
                description: getErrorMessage(error),
                intent: 'error',
                title: 'Submit failed',
            });
        } finally {
            setPendingAction(null);
        }
    };

    const deleteReport = async () => {
        if (!reportToDelete) {
            return;
        }

        setPendingAction({ action: 'delete', id: reportToDelete.id });

        try {
            await deleteReportMutation.mutateAsync(reportToDelete.id);
            notify({ intent: 'success', title: 'Report deleted' });
            setReportToDelete(null);
        } catch (error) {
            notify({
                description: getErrorMessage(error),
                intent: 'error',
                title: 'Delete failed',
            });
        } finally {
            setPendingAction(null);
        }
    };

    const renderActions = (report: WeeklyReport) => {
        const capabilities = getReportCapabilities(report, user);
        const action = pendingAction?.id === report.id ? pendingAction.action : null;

        return (
            <ReportActionBar
                capabilities={capabilities}
                compact
                exportUrl={report.pptx_file ? resolveReportAssetUrl(report.pptx_file) : null}
                onDelete={() => setReportToDelete(report)}
                onDuplicate={() => void duplicateReport(report)}
                onEdit={() => navigate(`/reports/${report.id}/edit`)}
                onPrint={() => navigate(`/reports/${report.id}`)}
                onSubmit={() => void submitReport(report)}
                onView={() => navigate(`/reports/${report.id}`)}
                pendingAction={action}
            />
        );
    };

    if (!canViewReports) {
        return (
            <PageContainer description="You do not have permission to view weekly reports." eyebrow="Reports" title="Reports">
                <EmptyState
                    description="Ask an administrator for the reports.view permission."
                    icon={<FileText aria-hidden="true" className="size-10" />}
                    title="Reports are unavailable"
                />
            </PageContainer>
        );
    }

    return (
        <PageContainer
            actions={
                canCreateReports ? (
                    <Button leftIcon={<FilePlus2 aria-hidden="true" className="size-4" />} onClick={() => navigate('/reports/create')}>
                        Create report
                    </Button>
                ) : null
            }
            description="Browse weekly reports, review status, and manage allowed report actions."
            eyebrow="Reports"
            title="Reports"
        >
            <DataToolbar
                actions={
                    <Button leftIcon={<RefreshCw aria-hidden="true" className="size-4" />} loading={reportsQuery.isFetching} onClick={() => void reportsQuery.refetch()} variant="outline">
                        Refresh
                    </Button>
                }
                filters={
                    <FilterBar
                        filters={[
                            {
                                id: 'status',
                                label: 'Status',
                                onChange: setStatus,
                                options: reportStatusOptions,
                                value: status,
                            },
                            {
                                id: 'department',
                                label: 'Department',
                                onChange: setDepartment,
                                options: departmentOptions,
                                value: department,
                            },
                            {
                                id: 'sort',
                                label: 'Sort',
                                onChange: (value) => setSort(value as ReportSortValue),
                                options: reportSortOptions,
                                value: sort,
                            },
                        ]}
                        onClear={resetFilters}
                    />
                }
                search={<SearchBar onChange={setSearch} placeholder="Search reports…" value={search} />}
            />

            {reportsQuery.isError && (
                <Alert
                    description={getErrorMessage(reportsQuery.error)}
                    icon={<AlertCircle aria-hidden="true" className="size-5" />}
                    intent="danger"
                    title="Reports could not be loaded"
                />
            )}

            {reportsQuery.isLoading ? (
                <ReportsTableSkeleton />
            ) : reports.length === 0 ? (
                <EmptyState
                    action={canCreateReports ? { label: 'Create report', onClick: () => navigate('/reports/create') } : undefined}
                    description="Reports from the API will appear here once they are created."
                    icon={<FileText aria-hidden="true" className="size-10" />}
                    title="No reports found"
                />
            ) : visibleReports.length === 0 ? (
                <EmptyState
                    action={{ label: 'Clear filters', onClick: resetFilters }}
                    description="No reports on this page match the current search, filters, and sorting criteria."
                    icon={<FileText aria-hidden="true" className="size-10" />}
                    title="No matching reports"
                />
            ) : (
                <section className="grid gap-4">
                    <SectionHeader
                        description={meta ? `${meta.total} reports total · page ${meta.current_page} of ${meta.last_page}` : undefined}
                        title="Report results"
                    />

                    <div className="hidden lg:block">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Week</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Department</TableHead>
                                    <TableHead>Employee</TableHead>
                                    <TableHead>Updated</TableHead>
                                    <TableHead className="min-w-80">Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {visibleReports.map((report) => (
                                    <TableRow key={report.id}>
                                        <TableCell className="font-medium">{report.week}</TableCell>
                                        <TableCell>
                                            <ReportStatusBadge label={report.status.label} status={report.status.value} />
                                        </TableCell>
                                        <TableCell>{report.department}</TableCell>
                                        <TableCell>{getEmployeeName(report)}</TableCell>
                                        <TableCell>{formatReportDate(report.updated_at)}</TableCell>
                                        <TableCell>{renderActions(report)}</TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </div>

                    <div className="grid gap-4 lg:hidden">
                        {visibleReports.map((report) => (
                            <ReportCard
                                actions={renderActions(report)}
                                description={report.executive_summary ?? report.achievements}
                                key={report.id}
                                meta={[
                                    { label: 'Department', value: report.department },
                                    { label: 'Employee', value: getEmployeeName(report) },
                                    { label: 'Updated', value: formatReportDate(report.updated_at) },
                                    { label: 'Week', value: report.week },
                                ]}
                                progress={getReportProgress(report.status.value)}
                                status={report.status.value}
                                subtitle={report.department}
                                title={getReportTitle(report)}
                            />
                        ))}
                    </div>

                    {meta && meta.last_page > 1 && <Pagination onPageChange={setPage} page={meta.current_page} pageCount={meta.last_page} />}
                </section>
            )}

            <ConfirmDeleteDialog
                onConfirm={() => void deleteReport()}
                onOpenChange={(open) => !open && setReportToDelete(null)}
                open={Boolean(reportToDelete)}
                resourceName={reportToDelete ? `report ${reportToDelete.week}` : 'this report'}
            />
        </PageContainer>
    );
}