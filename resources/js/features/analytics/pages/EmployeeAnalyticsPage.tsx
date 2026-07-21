import { UserRound } from 'lucide-react';
import { useEffect } from 'react';

import { EmployeeAvatar } from '@/components/business/employees';
import { Badge, Card, CardContent, CardDescription, CardHeader, CardTitle, Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui';
import { appConfig } from '@/config/app';
import { useAuthStore } from '@/stores/auth.store';

import { AnalyticsAccessDenied, AnalyticsEmptyState, AnalyticsErrorState, AnalyticsPageShell, AnalyticsSectionSkeleton, BarChart, ChartCard, ProgressMetric } from '../components';
import { useAnalyticsEmployeesQuery, useAnalyticsExportOptionsQuery } from '../hooks/useAnalytics';
import { useAnalyticsFilters } from '../hooks/useAnalyticsFilters';
import { canViewAnalytics, formatAnalyticsNumber, formatAnalyticsPercent, getChartPaletteColor } from '../utils/analytics-utils';

export function EmployeeAnalyticsPage() {
    const user = useAuthStore((state) => state.user);
    const { filters, queryFilters, resetFilters, setFilters } = useAnalyticsFilters();
    const employeesQuery = useAnalyticsEmployeesQuery(queryFilters);
    const exportOptionsQuery = useAnalyticsExportOptionsQuery();

    useEffect(() => {
        document.title = `Employee Analytics - ${appConfig.name}`;
    }, []);

    if (!canViewAnalytics(user)) {
        return <AnalyticsAccessDenied />;
    }

    const employees = employeesQuery.data?.data.data ?? [];
    const topEmployees = employees.slice(0, 8);

    return (
        <AnalyticsPageShell
            description="Compare employee productivity, report submission volume, approved reports, approval rate, and completion time."
            exportOptions={exportOptionsQuery.data?.data}
            exportOptionsLoading={exportOptionsQuery.isLoading}
            filters={filters}
            onFiltersChange={setFilters}
            onFiltersReset={resetFilters}
            title="Employee Analytics"
        >
            {employeesQuery.isLoading ? (
                <>
                    <AnalyticsSectionSkeleton />
                    <AnalyticsSectionSkeleton />
                </>
            ) : employeesQuery.isError ? (
                <AnalyticsErrorState error={employeesQuery.error} onRetry={() => void employeesQuery.refetch()} title="Unable to load employee analytics" />
            ) : employees.length === 0 ? (
                <AnalyticsEmptyState description="Employee productivity analytics will appear when reports match the selected filters." title="No employee analytics" />
            ) : (
                <>
                    <div className="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
                        <ChartCard
                            badge={<Badge intent="primary">{formatAnalyticsNumber(employeesQuery.data?.data.meta.total_employees ?? employees.length)} employees</Badge>}
                            description="Top employees by report volume."
                            title="Employee productivity"
                        >
                            <BarChart
                                ariaLabel="Employee productivity bar chart"
                                data={topEmployees.map((item, index) => ({ color: getChartPaletteColor(index), label: item.employee.name, value: item.total_reports }))}
                            />
                        </ChartCard>

                        <Card>
                            <CardHeader>
                                <div className="flex items-start justify-between gap-3">
                                    <div>
                                        <CardTitle>Top performer snapshot</CardTitle>
                                        <CardDescription>Highest report volume in the filtered result.</CardDescription>
                                    </div>
                                    <UserRound aria-hidden="true" className="size-5 text-primary" />
                                </div>
                            </CardHeader>
                            <CardContent className="grid gap-4">
                                {topEmployees[0] && (
                                    <div className="flex items-center gap-3 rounded-2xl border bg-muted/30 p-4">
                                        <EmployeeAvatar email={topEmployees[0].employee.email} name={topEmployees[0].employee.name} />
                                        <div className="min-w-0">
                                            <p className="font-medium text-foreground">{topEmployees[0].employee.name}</p>
                                            <p className="text-sm text-muted-foreground">{topEmployees[0].employee.department ?? 'No department'}</p>
                                        </div>
                                    </div>
                                )}
                                {topEmployees[0] && (
                                    <>
                                        <ProgressMetric label="Approval rate" value={topEmployees[0].approval_rate} />
                                        <div className="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
                                            <div className="rounded-2xl border bg-muted/30 p-4">
                                                <p className="text-sm text-muted-foreground">Submitted reports</p>
                                                <p className="mt-1 text-2xl font-semibold text-foreground">{formatAnalyticsNumber(topEmployees[0].reports_submitted)}</p>
                                            </div>
                                            <div className="rounded-2xl border bg-muted/30 p-4">
                                                <p className="text-sm text-muted-foreground">Avg completion time</p>
                                                <p className="mt-1 text-2xl font-semibold text-foreground">{topEmployees[0].average_completion_time.human}</p>
                                            </div>
                                        </div>
                                    </>
                                )}
                            </CardContent>
                        </Card>
                    </div>

                    <Card>
                        <CardHeader>
                            <CardTitle>Employee analytics detail</CardTitle>
                            <CardDescription>Data returned by `/api/analytics/employees`.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Employee</TableHead>
                                        <TableHead>Department</TableHead>
                                        <TableHead className="text-right">Reports</TableHead>
                                        <TableHead className="text-right">Submitted</TableHead>
                                        <TableHead className="text-right">Generated</TableHead>
                                        <TableHead className="text-right">Approval rate</TableHead>
                                        <TableHead className="text-right">Avg completion</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {employees.map((item) => (
                                        <TableRow key={item.employee.id}>
                                            <TableCell>
                                                <div className="flex items-center gap-3">
                                                    <EmployeeAvatar email={item.employee.email} name={item.employee.name} />
                                                    <div className="min-w-0">
                                                        <p className="font-medium text-foreground">{item.employee.name}</p>
                                                        <p className="text-xs text-muted-foreground">{item.employee.email}</p>
                                                    </div>
                                                </div>
                                            </TableCell>
                                            <TableCell>{item.employee.department ?? 'Unassigned'}</TableCell>
                                            <TableCell className="text-right">{formatAnalyticsNumber(item.total_reports)}</TableCell>
                                            <TableCell className="text-right">{formatAnalyticsNumber(item.reports_submitted)}</TableCell>
                                            <TableCell className="text-right">{formatAnalyticsNumber(item.generated_reports)}</TableCell>
                                            <TableCell className="text-right">{formatAnalyticsPercent(item.approval_rate)}</TableCell>
                                            <TableCell className="text-right">{item.average_completion_time.human}</TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>
                </>
            )}
        </AnalyticsPageShell>
    );
}
