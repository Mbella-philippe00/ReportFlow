import { CheckCircle2, Clock3, FileText, ShieldCheck, XCircle } from 'lucide-react';

import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui';
import type { EmployeeStatistics } from '@/types';
import { formatEmployeeDate } from '../utils/employee-utils';

const metricCards = [
    { key: 'total_reports', label: 'Total reports', icon: FileText },
    { key: 'submitted_reports', label: 'Submitted', icon: Clock3 },
    { key: 'manager_approved_reports', label: 'Manager approved', icon: ShieldCheck },
    { key: 'generated_reports', label: 'Final approved', icon: CheckCircle2 },
    { key: 'rejected_reports', label: 'Rejected', icon: XCircle },
] as const;

export function EmployeeStatisticsPanel({ statistics }: { statistics: EmployeeStatistics }) {
    return (
        <div className="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            {metricCards.map((metric) => {
                const Icon = metric.icon;

                return (
                    <Card key={metric.key}>
                        <CardHeader className="flex-row items-start justify-between gap-3">
                            <div>
                                <CardDescription>{metric.label}</CardDescription>
                                <CardTitle className="mt-2 text-3xl">{statistics[metric.key]}</CardTitle>
                            </div>
                            <span className="rounded-2xl bg-primary/10 p-3 text-primary">
                                <Icon aria-hidden="true" className="size-5" />
                            </span>
                        </CardHeader>
                        <CardContent>
                            <p className="text-xs text-muted-foreground">Last report: {formatEmployeeDate(statistics.last_report_at)}</p>
                        </CardContent>
                    </Card>
                );
            })}
        </div>
    );
}