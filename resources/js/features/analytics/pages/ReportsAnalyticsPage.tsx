import { FileText, Presentation } from 'lucide-react';
import { useEffect } from 'react';

import { Badge, Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';
import { appConfig } from '@/config/app';
import { useAuthStore } from '@/stores/auth.store';

import { AnalyticsAccessDenied, AnalyticsEmptyState, AnalyticsErrorState, AnalyticsPageShell, AnalyticsSectionSkeleton, BarChart, ChartCard, DistributionTable, DonutChart, ProgressMetric, StatusDistributionList } from '../components';
import { useAnalyticsExportOptionsQuery, useAnalyticsReportsQuery } from '../hooks/useAnalytics';
import { useAnalyticsFilters } from '../hooks/useAnalyticsFilters';
import { canViewAnalytics, formatAnalyticsNumber, getChartPaletteColor, getStatusChartColor } from '../utils/analytics-utils';

export function ReportsAnalyticsPage() {
    const user = useAuthStore((state) => state.user);
    const { filters, queryFilters, resetFilters, setFilters } = useAnalyticsFilters();
    const reportsQuery = useAnalyticsReportsQuery(queryFilters);
    const exportOptionsQuery = useAnalyticsExportOptionsQuery();

    useEffect(() => {
        document.title = `Reports Analytics - ${appConfig.name}`;
    }, []);

    if (!canViewAnalytics(user)) {
        return <AnalyticsAccessDenied />;
    }

    const reportsData = reportsQuery.data?.data.data;
    const totalReports = reportsQuery.data?.data.meta.total_reports ?? 0;

    return (
        <AnalyticsPageShell
            description="Analyze report volume, workflow status distribution, department mix, weekly trends, and generated PowerPoint output."
            exportOptions={exportOptionsQuery.data?.data}
            exportOptionsLoading={exportOptionsQuery.isLoading}
            filters={filters}
            onFiltersChange={setFilters}
            onFiltersReset={resetFilters}
            title="Reports Analytics"
        >
            {reportsQuery.isLoading ? (
                <>
                    <AnalyticsSectionSkeleton />
                    <AnalyticsSectionSkeleton />
                </>
            ) : reportsQuery.isError ? (
                <AnalyticsErrorState error={reportsQuery.error} onRetry={() => void reportsQuery.refetch()} title="Unable to load reports analytics" />
            ) : reportsData ? (
                <>
                    <div className="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
                        <ChartCard badge={<Badge intent="primary">{formatAnalyticsNumber(totalReports)} reports</Badge>} description="Distribution by backend workflow status." title="Report status distribution">
                            <DonutChart
                                ariaLabel="Report status distribution"
                                data={reportsData.status_distribution.map((status) => ({ color: getStatusChartColor(status.value), label: status.label, value: status.count }))}
                            />
                        </ChartCard>

                        <Card>
                            <CardHeader>
                                <div className="flex items-start justify-between gap-3">
                                    <div>
                                        <CardTitle>PowerPoint generation</CardTitle>
                                        <CardDescription>Generated report output from backend report generation fields.</CardDescription>
                                    </div>
                                    <Presentation aria-hidden="true" className="size-5 text-primary" />
                                </div>
                            </CardHeader>
                            <CardContent className="grid gap-4">
                                <div className="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
                                    <div className="rounded-2xl border bg-muted/30 p-4">
                                        <p className="text-sm text-muted-foreground">Approved reports</p>
                                        <p className="mt-1 text-2xl font-semibold text-foreground">{formatAnalyticsNumber(reportsData.generated_powerpoint_statistics.generated_reports)}</p>
                                    </div>
                                    <div className="rounded-2xl border bg-muted/30 p-4">
                                        <p className="text-sm text-muted-foreground">Reports with PPTX</p>
                                        <p className="mt-1 text-2xl font-semibold text-foreground">{formatAnalyticsNumber(reportsData.generated_powerpoint_statistics.reports_with_powerpoint)}</p>
                                    </div>
                                </div>
                                <ProgressMetric label="Generation rate" value={reportsData.generated_powerpoint_statistics.generation_rate} />
                            </CardContent>
                        </Card>
                    </div>

                    <div className="grid gap-6 xl:grid-cols-2">
                        <ChartCard description="Report volume by department." title="Department distribution">
                            {reportsData.department_distribution.length > 0 ? (
                                <BarChart
                                    ariaLabel="Department report distribution"
                                    data={reportsData.department_distribution.map((item, index) => ({ color: getChartPaletteColor(index), label: item.label, value: item.total }))}
                                />
                            ) : (
                                <AnalyticsEmptyState title="No department data" />
                            )}
                        </ChartCard>

                        <ChartCard description="Report volume grouped by report week." title="Weekly distribution">
                            {reportsData.weekly_distribution.length > 0 ? (
                                <BarChart
                                    ariaLabel="Weekly report distribution"
                                    data={reportsData.weekly_distribution.map((item, index) => ({ color: getChartPaletteColor(index), label: item.label, value: item.total }))}
                                />
                            ) : (
                                <AnalyticsEmptyState title="No weekly data" />
                            )}
                        </ChartCard>
                    </div>

                    <div className="grid gap-6 xl:grid-cols-2">
                        <Card>
                            <CardHeader>
                                <CardTitle>Status details</CardTitle>
                                <CardDescription>Count and proportional bar for every report status.</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <StatusDistributionList statuses={reportsData.status_distribution} />
                            </CardContent>
                        </Card>
                        <Card>
                            <CardHeader>
                                <div className="flex items-start justify-between gap-3">
                                    <div>
                                        <CardTitle>Department table</CardTitle>
                                        <CardDescription>Backend aggregation by department.</CardDescription>
                                    </div>
                                    <FileText aria-hidden="true" className="size-5 text-primary" />
                                </div>
                            </CardHeader>
                            <CardContent>
                                <DistributionTable items={reportsData.department_distribution} labelHeader="Department" valueHeader="Reports" />
                            </CardContent>
                        </Card>
                    </div>
                </>
            ) : (
                <AnalyticsEmptyState />
            )}
        </AnalyticsPageShell>
    );
}
