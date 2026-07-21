import { Building2 } from 'lucide-react';
import { useEffect } from 'react';

import { Badge, Card, CardContent, CardDescription, CardHeader, CardTitle, Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui';
import { appConfig } from '@/config/app';
import { useAuthStore } from '@/stores/auth.store';

import { AnalyticsAccessDenied, AnalyticsEmptyState, AnalyticsErrorState, AnalyticsPageShell, AnalyticsSectionSkeleton, BarChart, ChartCard, ProgressMetric } from '../components';
import { useAnalyticsDepartmentsQuery, useAnalyticsExportOptionsQuery } from '../hooks/useAnalytics';
import { useAnalyticsFilters } from '../hooks/useAnalyticsFilters';
import { canViewAnalytics, formatAnalyticsNumber, formatAnalyticsPercent, getChartPaletteColor } from '../utils/analytics-utils';

export function DepartmentAnalyticsPage() {
    const user = useAuthStore((state) => state.user);
    const { filters, queryFilters, resetFilters, setFilters } = useAnalyticsFilters();
    const departmentsQuery = useAnalyticsDepartmentsQuery(queryFilters);
    const exportOptionsQuery = useAnalyticsExportOptionsQuery();

    useEffect(() => {
        document.title = `Department Analytics - ${appConfig.name}`;
    }, []);

    if (!canViewAnalytics(user)) {
        return <AnalyticsAccessDenied />;
    }

    const departments = departmentsQuery.data?.data.data ?? [];

    return (
        <AnalyticsPageShell
            description="Analyze department report volume, active employees, validation rates, completion rates, and pending workflow load."
            exportOptions={exportOptionsQuery.data?.data}
            exportOptionsLoading={exportOptionsQuery.isLoading}
            filters={filters}
            onFiltersChange={setFilters}
            onFiltersReset={resetFilters}
            title="Department Analytics"
        >
            {departmentsQuery.isLoading ? (
                <>
                    <AnalyticsSectionSkeleton />
                    <AnalyticsSectionSkeleton />
                </>
            ) : departmentsQuery.isError ? (
                <AnalyticsErrorState error={departmentsQuery.error} onRetry={() => void departmentsQuery.refetch()} title="Unable to load department analytics" />
            ) : departments.length === 0 ? (
                <AnalyticsEmptyState description="Department analytics will appear when matching reports exist." title="No department analytics" />
            ) : (
                <>
                    <div className="grid gap-6 xl:grid-cols-2">
                        <ChartCard
                            badge={<Badge intent="primary">{formatAnalyticsNumber(departmentsQuery.data?.data.meta.total_departments ?? departments.length)} departments</Badge>}
                            description="Departments ranked by report volume."
                            title="Department productivity"
                        >
                            <BarChart
                                ariaLabel="Department productivity bar chart"
                                data={departments.map((item, index) => ({ color: getChartPaletteColor(index), label: item.department, value: item.total_reports }))}
                            />
                        </ChartCard>

                        <Card>
                            <CardHeader>
                                <div className="flex items-start justify-between gap-3">
                                    <div>
                                        <CardTitle>Department health</CardTitle>
                                        <CardDescription>Validation and completion rates by leading department.</CardDescription>
                                    </div>
                                    <Building2 aria-hidden="true" className="size-5 text-primary" />
                                </div>
                            </CardHeader>
                            <CardContent className="grid gap-4">
                                {departments.slice(0, 3).map((department) => (
                                    <div className="grid gap-3 rounded-2xl border bg-muted/30 p-4" key={department.department}>
                                        <div className="flex items-center justify-between gap-3">
                                            <div>
                                                <p className="font-medium text-foreground">{department.department}</p>
                                                <p className="text-sm text-muted-foreground">{formatAnalyticsNumber(department.active_employees)} active employees</p>
                                            </div>
                                            <Badge intent={department.pending_reports > 0 ? 'warning' : 'success'}>{formatAnalyticsNumber(department.pending_reports)} pending</Badge>
                                        </div>
                                        <ProgressMetric label="Validation rate" value={department.validation_rate} />
                                        <ProgressMetric label="Completion rate" value={department.completion_rate} />
                                    </div>
                                ))}
                            </CardContent>
                        </Card>
                    </div>

                    <Card>
                        <CardHeader>
                            <CardTitle>Department analytics detail</CardTitle>
                            <CardDescription>Data returned by `/api/analytics/departments`.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Department</TableHead>
                                        <TableHead className="text-right">Active employees</TableHead>
                                        <TableHead className="text-right">Reports</TableHead>
                                        <TableHead className="text-right">Generated</TableHead>
                                        <TableHead className="text-right">Rejected</TableHead>
                                        <TableHead className="text-right">Pending</TableHead>
                                        <TableHead className="text-right">Validation</TableHead>
                                        <TableHead className="text-right">Completion</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {departments.map((department) => (
                                        <TableRow key={department.department}>
                                            <TableCell className="font-medium">{department.department}</TableCell>
                                            <TableCell className="text-right">{formatAnalyticsNumber(department.active_employees)}</TableCell>
                                            <TableCell className="text-right">{formatAnalyticsNumber(department.total_reports)}</TableCell>
                                            <TableCell className="text-right">{formatAnalyticsNumber(department.generated_reports)}</TableCell>
                                            <TableCell className="text-right">{formatAnalyticsNumber(department.rejected_reports)}</TableCell>
                                            <TableCell className="text-right">{formatAnalyticsNumber(department.pending_reports)}</TableCell>
                                            <TableCell className="text-right">{formatAnalyticsPercent(department.validation_rate)}</TableCell>
                                            <TableCell className="text-right">{formatAnalyticsPercent(department.completion_rate)}</TableCell>
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
